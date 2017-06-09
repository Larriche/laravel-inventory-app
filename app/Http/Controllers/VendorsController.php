<?php

namespace App\Http\Controllers;

use App\Models\Vendor;

use Response;
use Validator;
use Illuminate\Http\Request;
use App\Services\VendorsService;
use App\Services\UtilityService;
use App\Services\FileUploadManager;

class VendorsController extends Controller
{
    /**
     * The VendorsService instance for managing actions pertaining
     * to types
     */
    protected $vendors_service;

	/**
	 * Create a new instance of this controller
	 */
	public function __construct(VendorsService $vendors_service)  
	{
        // This service deals with all the actions related to types
        $this->vendors_service = $vendors_service;

        $this->middleware('auth');
        $this->middleware('activated');
	}

    /**
     * Get a listing of all vendors
     * 
     * @return Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		$vendors = $this->vendors_service->getVendors($paginate = true);

        // For ajax request to refresh table of vendors,
        // return just the table
        if ($request->ajax()) {
            return view('vendors.table', compact('vendors'));
        }

		return view('vendors.index', compact('vendors'));
	}

    /**
     * Add a new vendor
     * 
     * @param  Request $request The HTTP request
     * @return Illuminate\Http\Response The HTTP response
     */
	public function store(Request $request)
	{
		// Rules for validating data
		$rules = [
		    'name' => 'required'
		];

		// Validate the passed data using the rules
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = ['errors' => $validator->messages()];

            return Response::json($response , 422);
        }

        // If vendor logo has been uploaded, validate the photo
		if ($request->file('logo')) {
            // Create a new instance of FileUploadManager class
            $file = new FileUploadManager($request->file('logo'));

            // Settings to use for validating the uploaded image
            $settings = [
                'max_width' => 500,
                'max_height' => 500,
                'max_size' => 1024,
                'valid_mimes' => ['image/jpeg', 'image/png'],
                'mimes_message' => 'File must be an image of type jpeg or png'
            ];
            
            // Validate the image using the settings
            // and get back an array of error messages
            $photo_errors = $file->validate($settings);
           
            // If there were errors from the photo validation
            // Return the error messages as the response
            if (count($photo_errors)) {
                $response = ['errors' => $photo_errors];

                return Response::json($response , 422);
            }
        }

        // Validate the uniqueness of this vendor
        $regex = UtilityService::getSimilarityRegex($request->name);

        $existing = Vendor::whereRaw('name REGEXP "'.$regex.'" ')->first();

        if ($existing) {
            $validator->getMessageBag()->add('name', 'This vendor already exists');
            $response = ['errors' => $validator->messages()];

            return Response::json($response, 422);
        }

        $vendor = $this->vendors_service->addVendor($request);

        if ($vendor) {
        	$response = ['message' => 'Vendor has been added'];

        	return Response::json($response, 200);
        } else {
        	$response = ['errors' => ['An unknown error occurred when saving vendor']];

            return Response::json($response , 422);
        }
	}

    /**
     * Show the vendor with the given ID
     * 
     * @param int $id The ID of the vendor
     * @return Illuminate\Http\Response The HTTP response
     */
	public function show($id)
	{
		$vendor = $this->vendors_service->getVendor($id);

		if ($vendor) {
			return Response::json($vendor, 200);
		} else {
			$response = ['errors' => ['This vendor does not exist']];

			return Response::json($response, 404);
		}
	}

    /**
     * Update the vendor with the given ID
     * 
     * @param  int  $id  The ID of the vendor
     * @param  Request $request The HTTP request
     * @return Illuminate\Http\Response The HTTP response
     */
	public function update($id, Request $request)
	{
		$vendor = $this->vendors_service->getVendor($id);

		if (!$vendor) {
			$response = ['errors' => ['This vendor does not exist']];

			return Response::json($response, 404);
		}

        $regex = UtilityService::getSimilarityRegex($request->name);

        $existing = Vendor::whereRaw('name REGEXP "'.$regex.'" ')
            ->where('id', '!=', $vendor->id)->first();

        if ($existing) {
            $validator->getMessageBag()->add('name', 'This vendor already exists');
            $response = ['errors' => $validator->messages()];

            return Response::json($response, 422);
        }

		// If a new logo is uploaded, validate the uploaded image
		if ($request->file('logo')) {
            // Create a new instance of FileUploadManager class
            $file = new FileUploadManager($request->file('logo'));

            // Settings to use for validating the uploaded image
            $settings = [
                'max_width' => 500,
                'max_height' => 500,
                'max_size' => 1024,
                'valid_mimes' => ['image/jpeg', 'image/png'],
                'mimes_message' => 'File must be an image of type jpeg or png'
            ];
            
            // Validate the image using the settings
            // and get back an array of error messages
            $photo_errors = $file->validate($settings);
           
            // If there were errors from the photo validation
            // Return the error messages as the response
            if (count($photo_errors)) {
                $response = ['errors' => $photo_errors];

                return Response::json($response , 422);
            }
        }

        $vendor = $this->vendors_service->updateVendor($vendor, $request);

        $response = ['message' => 'Vendor has been updated'];

        return Response::json($response, 200);
	}

    /**
     * Delete the vendor with the given ID
     * 
     * @param  int $id The ID of the vendor
     * @return Illuminate\Http\Response The HTTP response
     */
	public function destroy($id)
	{
		$vendor = $this->vendors_service->getVendor($id);

		if (!$vendor) {
			$response = ['errors' => ['This vendor does not exist']];

			return Response::json($response, 404);
		}	

		$this->vendors_service->deleteVendor($vendor);

		$response = ['message' => 'Vendor has been deleted'];

        return Response::json($response, 200);
	}
}
