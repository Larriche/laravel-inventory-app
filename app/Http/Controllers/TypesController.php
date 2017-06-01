<?php

namespace App\Http\Controllers;

use Validator;
use Response;
use Illuminate\Http\Request;
use App\Services\TypesService;

class TypesController extends Controller
{
	/**
     * The TypesService instance for managing actions pertaining
     * to types
     */
    protected $types_service;

	/**
	 * Create a new instance of this controller
	 */
	public function __construct(TypesService $types_service)  
	{
        // This service deals with all the actions related to types
        $this->types_service = $types_service;
	}

    /**
     * Get a listing of all types
     * 
     * @return Illuminate\Http\Response The HTTP response
     */
	public function index(Request $request)
	{
	    $types = $this->types_service->getTypes();

	    return $types;	
	}

    /**
     * Add a new item type
     * 
     * @param  Illuminate\Http\Request $request The HTTP request
     * @return Illuminate\Http\Response The HTTP response
     */
	public function store(Request $request)
	{
		// Rules for validating request data
		$rules = [
		    'name' => 'required',
		];

		// Validate the passed data using the rules
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = ['errors' => $validator->messages()];

            return Response::json($response , 422);
        }

        $type = $this->types_service->addType($request);

        if ($type) {
        	$response = ['message' => 'Type has been added'];

        	return Response::json($response, 200);
        } else {
        	$response = ['errors' => ['An unknown error occurred when saving type']];

            return Response::json($response , 422);
        }
	}

    /**
     * Get the type with the given ID
     * 
     * @param  int $id ID of type
     * @return Illuminate\Http\Response The HTTP response
     */
	public function show($id)
	{
		$type = $this->types_service->getType($id);

		if ($type) {
			return Response::json($type, 200);
		} else {
			$response = ['errors' => ['This type does not exist']];

			return Response::json($response, 404);
		}
	}

	public function update($id, Request $request)
	{
		
	}
}
