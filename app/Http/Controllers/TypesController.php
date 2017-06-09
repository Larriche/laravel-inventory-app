<?php

namespace App\Http\Controllers;

use App\Models\Type;

use Validator;
use Response;
use Illuminate\Http\Request;
use App\Services\TypesService;
use App\Services\UtilityService;

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

        $this->middleware('auth');
        $this->middleware('activated');
	}

    /**
     * Get a listing of all types
     * 
     * @return Illuminate\Http\Response The HTTP response
     */
	public function index(Request $request)
	{
	    $types = $this->types_service->getTypes($paginate = true);

	    // For ajax request to refresh table of types,
        // return just the table
        if ($request->ajax()) {
            return view('types.table', compact('types'));
        }

		return view('types.index', compact('types'));
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
        
        // Validate the uniqueness of this item type
        $regex = UtilityService::getSimilarityRegex($request->name);

        $existing = Type::whereRaw('name REGEXP "'.$regex.'" ')->first();

        if ($existing) {
        	$validator->getMessageBag()->add('name', 'This type already exists');
            $response = ['errors' => $validator->messages()];

            return Response::json($response, 422);
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

    /**
     * Update the type with the given ID
     * 
     * @param  int  $id  The ID of the type to be updated
     * @param  Illuminate\Http\Request $request The HTTP request
     * @return Illuminate\Http\Response The HTTP response
     */
	public function update($id, Request $request)
	{
		$type = $this->types_service->getType($id);

		if (!$type) {
			$response = ['errors' => ['This type does not exist']];

			return Response::json($response, 404);
		}

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
        
        // Validate the uniqueness of this item type
        $regex = UtilityService::getSimilarityRegex($request->name);

        $existing = Type::whereRaw('name REGEXP "'.$regex.'" ')->where('id','!=', $type->id)->first();

        if ($existing) {
        	$validator->getMessageBag()->add('name', 'This type already exists');
            $response = ['errors' => $validator->messages()];

            return Response::json($response, 422);
        }

		$type = $this->types_service->updateType($type, $request);

		$response = ['message' => 'Type has been updated'];

        return Response::json($response, 200);
	}

    /**
     * Delete the type with the given ID
     * 
     * @param  int $id The ID of the type to be deleted
     */
	public function destroy($id)
	{
	    $type = $this->types_service->getType($id);

		if (!$type) {
			$response = ['errors' => ['This type does not exist']];

			return Response::json($response, 404);
		}	

		$this->types_service->deleteType($type);

		$response = ['message' => 'Type has been deleted'];

        return Response::json($response, 200);
	}
}
