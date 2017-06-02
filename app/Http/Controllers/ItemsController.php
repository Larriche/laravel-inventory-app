<?php

namespace App\Http\Controllers;

use App\Models\Item;

use Response;
use Validator;
use Illuminate\Http\Request;
use App\Services\ItemsService;

class ItemsController extends Controller
{
    /**
     * The ItemsService instance for managing actions pertaining
     * to items
     */
    protected $items_service;

	/**
	 * Create a new instance of this controller
	 */
	public function __construct(ItemsService $items_service)  
	{
        // This service deals with all the actions related to types
        $this->items_service = $items_service;
	}

    /**
     * Display a paginated listing of items
     * 
     * @param  Request $request The HTTP request
     * @return Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		// Rules for validating request data
		$rules = [
		    'price' => 'numeric'
		];

		// Validate the passed data using the rules
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = ['errors' => $validator->messages()];

            return Response::json($response , 422);
        }

        $items = $this->items_service->getItems($request);

        return $items;
	}

    /**
     * Add a new item to the database
     * 
     * @param  Request $request The HTTP request
     * @return Response The HTTP response
     */
	public function store(Request $request)
	{
		// Rules for validating request data
		$rules = [
		    'name' => 'required',
		    'vendor_id' => 'required',
		    'type_id' =>'required',
		    'serial_number' => 'required',
		    'weight' =>'required',
		    'color' => 'required',
		    'price' => 'required|numeric',
		];

		// Validate the passed data using the rules
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = ['errors' => $validator->messages()];

            return Response::json($response , 422);
        }

        // If item image is uploaded, validate image
        // If vendor logo has been uploaded, validate the photo
		if ($request->file('image')) {
            // Create a new instance of FileUploadManager class
            $file = new FileUploadManager($request->file('image'));

            // Settings to use for validating the uploaded image
            $settings = [
                'max_width' => 800,
                'max_height' => 800,
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

        $existing = Item::whereRaw('name REGEXP "'.$regex.'" ')->first();

        if ($existing) {
            $response = ['errors' => ['This item already exists']];

            return Response::json($response, 422);
        }

        $item = $this->items_service->addItem($request);

        if ($item) {
        	$response = ['message' => 'Item has been added'];

        	return Response::json($response, 200);
        } else {
        	$response = ['errors' => ['An unknown error occurred when saving item']];

            return Response::json($response , 422);
        }
	}

    /**
     * Display the item with the given ID
     * 
     * @param  int $id The ID of item to retrieve
     * @return Illuminate\Http\Response The item
     */
	public function show($id)
	{
		$item = $this->items_service->getItem($id);

		if ($item) {
			return Response::json($item, 200);
		} else {
			$response = ['errors' => ['This item does not exist']];

			return Response::json($response, 404);
		}
	}

    /**
     * Update the item with the given ID
     * 
     * @param  int  $id  The ID of the item to be updated
     * @param  Request $request The HTTP request
     * @return Response $response The HTTP response
     */
	public function update($id, Request $request)
	{
		$item = $this->items_service->getItem($id);

		if (!$item) {
			$response = ['errors' => ['This item does not exist']];

			return Response::json($response, 404);
		}

        $regex = UtilityService::getSimilarityRegex($request->name);

        $existing = Item::whereRaw('name REGEXP "'.$regex.'" ')
            ->where('id', '!=', $item->id)->first();

        if ($existing) {
            $response = ['errors' => ['This item already exists']];

            return Response::json($response, 422);
        }

		// If a new image is uploaded, validate the uploaded image
		if ($request->file('image')) {
            // Create a new instance of FileUploadManager class
            $file = new FileUploadManager($request->file('image'));

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

        $item = $this->items_service->update($item, $request);

        $response = ['message' => 'Item has been updated'];

        return Response::json($response, 200);
	}


    /**
     * Delete the item with the given ID
     * 
     * @param  int $id The ID of the item
     * @return Illuminate\Http\Response The HTTP response
     */
	public function delete($id)
	{
		$item = $this->items_service->getItem($id);

		if (!$item) {
			$response = ['errors' => ['This item does not exist']];

			return Response::json($response, 404);
		}	

		$this->items_service->delete($item);

		$response = ['message' => 'Item has been deleted'];

        return Response::json($response, 200);
	}
}
