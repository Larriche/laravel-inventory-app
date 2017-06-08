<?php

namespace App\Http\Controllers;

use ZipArchive;
use Illuminate\Http\Request;
use App\Services\BackupsService;

class BackupsController extends Controller
{
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
     * @return [type] [description]
     */
    public function backup()
    {
    	$server_name   = "localhost";
		$username      = "richman";
		$password      = "larry123";
		$database_name = "inventory";
		$date_string   = date("Y_m_d_h_m_s");
		$sql_path = base_path()."/storage/inventory_backups/inventory_".$date_string.".sql";
		$backup_folder = base_path()."/storage/inventory_backups";

		$backups_service = new BackupsService();

		// If backups folder does not exist, create it
		if (!file_exists($backup_folder)){
			mkdir($backup_folder);
		}
        
        // Create backup sql file
        $command = "C:/xampp/mysql/bin/mysqldump --routines -h {$server_name} -u {$username} ";
        $command = strlen($password) ? $command."-p{$password} " : $command;
        $command .= "{$database_name} > ". $sql_path;

    	$cmd = exec($command, $output, $return);

    	// Copy uploaded images folder to inventory backups
    	$images_folder_path = base_path()."/storage/app/public/uploads";

        // Zip images folder
        $files = array_diff(scandir($images_folder_path), array('.', '..'));
        $zip_path = $images_folder_path."/uploads.zip";

        touch($zip_path);

        $zip = new ZipArchive();

        try {
            $res = $zip->open($zip_path, ZipArchive::CREATE);

            if ($res === TRUE) {
                foreach($files as $file) {
                	if ($file != 'uploads.zip') {
	                	$inner_files = array_diff(scandir($images_folder_path.'/'.$file), array('.', '..'));

	                	foreach($inner_files as $inner) {
	                        $zip->addFile($images_folder_path.'/'.$file.'/'.$inner, $file.'/'.$inner);
	                    }
	                }
                }
                
                $zip->close();
            }
            
        } catch (Exception $ex) {
        	return false;
        }

        // Move created zip file to inventory_backups
        $uploads_zip = $backup_folder.'/uploads_'.$date_string.".zip";
        rename($zip_path, $uploads_zip);

        // Create a final zip of uploads and sql file
        $backup_zip_path = $backup_folder.'/backups_'.$date_string.".zip";

        touch($backup_zip_path);

        $backup_zip = new ZipArchive();

        try {
            $res = $backup_zip->open($backup_zip_path, ZipArchive::CREATE);

            if ($res === TRUE) {
            	$backup_zip->addFile($sql_path, "db_backup_".$date_string.".sql");
            	$backup_zip->addFile($uploads_zip, "uploads_".$date_string.".zip");
            	$backup_zip->close();

            	// Delete the upload and sql files so it's left with
            	// only the final backups zip
            	unlink($sql_path);
            	unlink($uploads_zip);
            }
        } catch (Exception $ex) {
        	return false;
        }

        if(!$return){
            return response()->download(storage_path('inventory_backups/backups_'.$date_string.'.zip'));
        } 
        else{
            $message = 'Backup failed to complete.';
            return redirect()->back()->withErrors([$message]);
        }
    }
}
