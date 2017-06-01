<?php

namespace App\Services;

/*
|--------------------------------------------------------------------------
| TypesService
|--------------------------------------------------------------------------
|
| This is a helper class for managing the CRUD operation regarding item types
|
*/

use App\Models\Type;

class TypesService
{
	/**
	 * Get all item types in the database
	 * 
	 * @return array A collection of item types
	 */
	public function getTypes()
	{
		$types = Type::all();

		return $types;
	}

    /**
     * Add a new type to the database
     * 
     * @param Illuminate\Http\Request The HTTP request
     */
	public function addType($request)
	{
		$data = [
		    'name' => $request->name
		];

		$type = Type::create($data);

		return $type;
	}

    /**
     * Get the type with the given ID
     * 
     * @param  int $id The ID of the type
     * @return App\Models\Type The item type or null if not found
     */
	public function getType($id)
	{
		$type = Type::find($id);

		return $type;
	}

    /**
     * Update the given type with new data
     * 
     * @param  App\Models\Type $type  The type to be updated
     * @param  Illuminate\Http\Request The HTTP request
     * @return App\Models\Type The updated type
     */
	public function updateType($type, $request)
	{
		// Data to use for updating type
		$data = [];

		if ($request->has('name')) {
			$data['name'] = $request->name;
		}

		$type->update($data);

		return $type;
	}

    /**
     * Delete the given type from the database
     * 
     * @param  App\Models\Type $type The type to be deleted
     */
	public function deleteType($type)
	{
		$type->delete();
	}
}
