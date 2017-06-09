<?php

namespace App\Http\Controllers;

use Response;
use ZipArchive;
use Illuminate\Http\Request;
use App\Services\BackupsService;

class BackupsController extends Controller
{
    /**
     * Create a new instance of BackupsController
     * 
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('activated');
    }

	/**
	 * Show the landing page for managing backups
	 * 
	 * @return Illuminate\Http\Response
	 */
    public function index()
    {
    	return view('backups.index');
    }

    /**
     * Bundle the app's data into a zip containing sql file for database backup and 
     * images folder and return the zip file for download
     * 
     * @return Illuminate\Http\Response
     */
    public function backup()
    {
        $settings = [
            'username' => env("DB_USERNAME"),
            'password' => env("DB_PASSWORD"),
            'db_name'  => env("DB_DATABASE"),
            'server'   => env("DB_HOST"),
            'backup_destination' => base_path()."/storage/inventory_backups",
            'mysql_bin_path' => env("MYSQL_BIN")
        ];

		$backups_service = new BackupsService($settings);
        $result = $backups_service->backup(base_path()."/storage/app/public/uploads");

        if($result['status'] == 'success'){
            return response()->download($result['file']);
        } 
        else{
            $message = 'Backup failed to complete.'.$result['error'];
            return redirect()->back()->withErrors([$message]);
        }
    }

    /**
     * Restore database from an uploaded SQL file
     * 
     * @param  Request $request The HTTP request
     * @return Illuminate\Http\Response The HTTP response
     */
    public function restore(Request $request)
    {
        $this->validate($request, ['sql_file' => 'required']);

        if($request->file('sql_file')){
            $extension = $request->file('sql_file')->getClientOriginalExtension();

            if($extension != 'sql'){
                if($request->ajax())
                    return ['errors' => ['Invalid backup file uploaded']];
                else
                    return redirect()->back()->withErrors('Invalid backup file uploaded');
            }

            $fileName = 'restore.sql';
            $request->file('sql_file')->move(base_path().'/storage/',$fileName);
        }

        $server_name   = "localhost";
        $username      = env("DB_USERNAME");
        $password      = env("DB_PASSWORD");
        $database_name = env("DB_DATABASE");   
        $path = base_path().'/storage/restore.sql';
        $mysql_bin = env("MYSQL_BIN");

        $cmd = exec("{$mysql_bin}/mysql -h {$server_name} -u {$username} {$database_name} < " 
            . $path, $output, $return);

        $command = "{$mysql_bin}/mysql -h {$server_name} -u {$username} ";
        $command = strlen($password) ? $command."-p{$password} " : $command;
        $command .= "{$database_name} < ". $path;

        $cmd = exec($command, $output, $return);

        if(!$return){
            $message = 'Database has been restored with loaded data';
        } 
        else{
            $message = 'Database could not be restored';
        }

        if($request->ajax()){
            $response = ['message' => 'Restore was successful'];

            return Response::json($response, 200);
        }

        return redirect()->back()->with('status', $message);
    }
}
