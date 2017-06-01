<?php

namespace App\Services;

/*
|--------------------------------------------------------------------------
| VendorsService
|--------------------------------------------------------------------------
|
| This is a helper class for managing the CRUD operation regarding Vendors
| of the items in the inventory
|
*/

use App\Models\Vendor;
use FileUploadManager;

class VendorsService
{
	/**
	 * This method returns all vendors from the database
	 * 
	 * @return array The collection of vendors
	 */
	public function getVendors()
	{
		$vendors = Vendor::all();
		return $vendors;
	}

    /**
     * This method is called to add a new vendor to the database after all
     * validation has been done by the controller
     * 
     * @param Illuminate\Http\Request $request The HTTP request
     * @return  App\Models\Vendor  $vendor The newly added vendor
     */
	public function addVendor($request)
	{
		// Data for creating a new vendor
		$data = [
		    'name' => $request->name
		];

        // Add new vendor to database
		$vendor = Vendor::create($data);

		if ($request->file('logo')) {
            $destination = $this->uploadVendorLogo($vendor->id, $request->file('logo'));

            if ($destination) {
            	$vendor->logo_url = $destination;
            	$vendor->save();
            }
		}

		return $vendor;
	}

    /**
     * Get the vendor with the given ID or return null if not exist
     * 
     * @param  int $id The ID of the vendor
     * @return App\Models\Vendor $vendor The vendor with given ID or null if not found
     */
	public function getVendor($id)
	{
		$vendor = Vendor::find($id);

		return $vendor;
	}
    
    /**
     * Update the given vendor with the data in the request
     * 
     * @param  App\Models\Vendor $vendor  The vendor to be updated
     * @param  Illuminate\Http\Request $request The HTTP request
     * @return App\Models\Vendor The updated vendor
     */
	public function updateVendor($vendor, $request)
	{
		$data = [];

		if ($request->has('name')) {
			$data['name'] = $request->name;
		}

		$vendor->update($data);

		if ($request->file('logo')) {
            $destination = $this->uploadVendorLogo($vendor->id, $request->file('logo'));

            if ($destination) {
            	$vendor->logo_url = $destination;
            	$vendor->save();
            }
		}

		return $vendor;
	}

    /**
     * Delete the given vendor
     * 
     */
	public function deleteVendor($vendor)
	{
		$vendor->delete();
	}

    /**
     * Upload a new logo for the vendor with the given ID
     * 
     * @param  int $vendor_id  The ID of the vendor
     * @param  string $uploaded_file The uploaded file
     * @return string $destination The storage path after the image is uploaded
     */
	public function uploadVendorLogo($vendor_id, $uploaded_file)
	{
		$file = new FileUploadManager($uploaded_file);

		// Path of folder to save uploaded logo in
        $path = 'vendor_logos';
        
        // Move the file to the specified folder saving it with name 'logo_' 
        // with ID of vendor appended
        $name = 'logo_'.$vendor_id;
        $destination = $file->move($path, $name, 'jpg');
        
        return $destination;
	}
}