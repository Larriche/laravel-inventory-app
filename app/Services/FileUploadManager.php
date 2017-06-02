<?php

namespace App\Services;

use File;

class FileUploadManager
{
	/**
	 * The uploaded file we are processing
	 * 
	 * @var the uploaded file
	 */
	private $file;

    /**
     * Create a new instance of the upload manager
     * 
     * @param string $file the path of the uploaded file
     */
	public function __construct($file)
	{
		$this->file = $file;
	}

    /**
     * Get the extension of the file we are processing
     * 
     * @return $string The extension of the file
     */
	public function getExtension()
	{
		$name = $this->file->getClientOriginalName();
		$parts = explode(".", $name);
		$extension = $parts[ count($parts) - 1 ];

		return $extension;
	}

    /**
     * Get the original name of the file we are processing without the extension
     * 
     * @return $string The original name of the file
     */
	public function getOriginalName()
	{
		$fullName = $this->file->getClientOriginalName();
		$parts = explode(".", $fullName);
		$nameParts = array_slice($parts, 0, count($parts) - 1, true);

		return implode(".", $nameParts);
	}

    /**
     * Validate uploaded file
     * 
     * @param  array $settings Property-value pairs to validate
     * @return array Error messages from validation
     */
	public function validate($settings)
	{
		$errors = [];
        
		$file = $this->file;
		$type = $file->getMimeType();
		$size = $file->getClientSize() / 1024;
		list($width, $height) = getimagesize($file);
        
		if (isset($settings['max_width'])) {
			$maxWidth = $settings['max_width'];

			if ($width > $maxWidth) {
	            $errors[] = 'The width of the photo must be less than or equal to ' . $maxWidth . 'px.';
	        }
		}

		if (isset($settings['max_height'])) {
			$maxHeight = $settings['max_height'];

			if ($height > $maxHeight) {
	            $errors[] = 'The height of the photo must be less than or equal to ' . $maxHeight . 'px.';
	        }
		}	

		if (isset($settings['max_size'])) {
			$maxSize = $settings['max_size'];

			if ($size > $maxSize) {
	            $errors[] = 'The size of the photo must not be greater than '.$maxSize.' KB '; 
			}
		}

		if (isset($settings['valid_mimes'])) {
			$mimes = $settings['valid_mimes'];

			if (!in_array($type, $mimes)) {
				$errors[] = $settings['mimes_message'];
			}
		}

		return $errors;
	}

    /**
     * Move the uploaded file to a new location
     * 
     * @param  string $path the folder location of the new path
     * @param  string $filename the name to save the file as
     */
	public function move($folder, $fileName, $extension = null)
	{
		$fileName = str_replace(["%" ,"*","!", '/'] , "_" , $fileName) . ".";

		if ($extension) {
			$fileName .= $extension;
		}
		else{
			$fileName .= $this->getExtension();
		}
        
        $destination = 'public/uploads/'.$folder;

        $fullDestination = storage_path('app/'.$destination);
        $fullDestination = str_replace('\\', '/', $fullDestination);
        $fullDestination = str_replace('//', '/', $fullDestination);

        is_dir($fullDestination) ? : mkdir($fullDestination, 0777, true);

		if ($saved_path = $this->file->storeAs($destination, $fileName)) {
			return $saved_path;
		}

		return null;
	}
}