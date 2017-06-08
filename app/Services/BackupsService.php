<?php

namespace App\Services;

use ZipArchive;

class BackupsService
{
	/**
	 * Username for database connection
	 * 
	 * @var string
	 */
	private $db_username;

    /**
     * Password for database connection
     * 
     * @var string
     */
	private $db_password;

    /**
     * Database name 
     * 
     * @var string
     */
	private $db_name;

    /**
     * Database host 
     * 
     * @var string
     */
	private $db_server;

    /**
     * Path of mysql bin folder
     * Needed to call mysqldump 
     * 
     * @var string
     */
	private $mysql_bin;

    /**
     * Full path of destination to store backup
     * 
     * @var string
     */
	private $backup_destination;


    /**
     * Create a new instance of BackupsService
     * 
     * @param  $settings An array of settings needed to do backup
     */
	public function __construct($settings)
	{
		$this->db_username = $settings['username'];
		$this->db_password = $settings['password'];
		$this->db_server = $settings['server'];
		$this->db_name = $settings['db_name'];
		$this->backup_destination = $settings['backup_destination'];
		$this->mysql_bin = $settings['mysql_bin_path'];
		$this->date_string  = date("Y_m_d_h_m_s"); 
	}

	/**
	 * Create a backup sql from the current database contents
	 * 
	 * @return boolean Status of creation
	 */
	public function createSqlBackup()
	{
		$sql_path = $this->backup_destination."/".$this->db_name."_".$this->date_string.".sql";

		// If backups folder does not exist, create it
		if (!file_exists($this->backup_destination)){
			mkdir($this->backup_destination);
		}
        
        // Create backup sql file
        $command = "{$this->mysql_bin}/mysqldump --routines -h {$this->db_server} -u {$this->db_username} ";
        $command = strlen($this->db_password) ? $command."-p{$this->db_password} " : $command;
        $command .= "{$this->db_name} > ". $sql_path;

    	$cmd = exec($command, $output, $return);

    	if(!$return){
    		return true;
        } 
        
        return false;
	}

    /**
     * Create a zip file out of the given uploads folder and moves it
     * to backup destination
     * 
     * @param  string $uploads_folder The uploads folder's path
     * @return boolean   The success state of the operation
     */
	public function zipUploadsFolder($uploads_folder)
	{
		// Zip images folder
        $files = array_diff(scandir($uploads_folder), array('.', '..'));
        $zip_path = $uploads_folder."/uploads.zip";

        touch($zip_path);

        $zip = new ZipArchive();

        try {
            $res = $zip->open($zip_path, ZipArchive::CREATE);

            if ($res === TRUE) {
                foreach($files as $file) {
                	if ($file != 'uploads.zip') {
	                	$inner_files = array_diff(scandir($uploads_folder.'/'.$file), array('.', '..'));

	                	foreach($inner_files as $inner) {
	                        $zip->addFile($uploads_folder.'/'.$file.'/'.$inner, $file.'/'.$inner);
	                    }
	                }
                }
                
                $zip->close();

                // Move created zip file to inventory_backups
		        $uploads_zip = $this->backup_destination.'/uploads_'.$this->date_string.".zip";
		        rename($zip_path, $uploads_zip);

                return true;
            }

            return false;
            
        } catch (Exception $ex) {
        	return false;
        }
	}

    /**
     * Create a final backup zip consisting of zipped uploads folder and sql backup file
     * 
     * @param  string $sql_path  Full system path of created sql file
     * @param  string $uploads_zip_path Full system path of zipped uploads file
     * @return boolean The success status of the operation
     */
	public function createBackupZip($sql_path, $uploads_zip_path)
	{
		// Create a final zip of uploads and sql file
        $backup_zip_path = $this->backup_destination.'/backups_'.$this->date_string.".zip";

        touch($backup_zip_path);

        $backup_zip = new ZipArchive();

        try {
            $res = $backup_zip->open($backup_zip_path, ZipArchive::CREATE);

            if ($res === TRUE) {
            	$backup_zip->addFile($sql_path, "db_backup_".$this->date_string.".sql");
            	$backup_zip->addFile($uploads_zip_path, "uploads_".$this->date_string.".zip");
            	$backup_zip->close();

            	// Delete the upload and sql files so it's left with
            	// only the final backups zip
            	unlink($sql_path);
            	unlink($uploads_zip_path);

            	return true;
            }

            return false;
        } catch (Exception $ex) {
        	return false;
        }
	}

    /**
     * This method calls other methods to do a complete backup of data
     * 
     * @param  string $uploads_folder Full path of uploads folder
     * @return array A response array giving status of operation and error messages if any
     */
	public function backup($uploads_folder)
	{
		$response = [];

		if ($this->createSqlBackup()) {
			if ($this->zipUploadsFolder($uploads_folder)) {
				$uploads_path = $this->backup_destination.'/uploads_'.$this->date_string.".zip";
				$sql_path = $this->backup_destination."/".$this->db_name."_".$this->date_string.".sql";

				if ($this->createBackupZip($sql_path, $uploads_path)) {
					$response['status'] = 'success';
					$response['file'] = $this->backup_destination."/backups_".$this->date_string.".zip";
				} else {
					$response['status'] = 'error';
				    $response['error'] = 'An error occurred when creating backup zip file';
				}
			} else {
				$response['status'] = 'error';
				$response['error'] = 'An error occurred when zipping uploads folder';
			}
		} else {
			$response['status'] = 'error';
			$response['error'] = 'An error occurred when creating backup sql file';
		}

		return $response;
	}
}