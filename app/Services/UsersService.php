<?php

namespace App\Services;

/*
|--------------------------------------------------------------------------
| UsersService
|--------------------------------------------------------------------------
|
| This is a helper class for managing the CRUD operations regarding users
|
*/

use App\Models\User;
use App\Models\UserStatus;

use Hash;

class UsersService
{
	/**
	 * Get a listing of users filtered by params passed in request
	 * 
	 * @param  Illuminate\Http\Request $request The HTTP request
	 * @return array An array of users
	 */
	public function getUsers($request)
	{
		// Role to filter users by
		$role_id = ($request->has('role_id') && $request->role_id) ? $request->role_id : null;

		// Status to filter users by
		$status_id = ($request->has('status_id') && $request->status_id) ? $request->status_id: null;

		// Number of users to return per call
		$per_page = ($request->has('per_page') && $request->per_page) ? $request->per_page : 20;

		// Start of users query
		$users = User::with('role', 'status');

        // Filter by role if role is supplied
        if ($role_id) {
            $users = $users->where('role_id', $role_id);
        }

        // Filter by status if status id is supplied
        if ($status_id) {
            $users = $users->where('status_id', $status_id);
        }

        return $users->orderBy('name', 'asc')->paginate($per_page);
	}

	/**
	 * This method adds a new user after the necessary validation has been done 
	 * by the controller
	 * 
	 * @param Illuminate\Http\Request $request The HTTP request
	 */
	public function addUser($request)
	{
		// Data for creating new user
		$data = [
		    'username' => $request->username,
		    'password' => Hash::make($request->password),
		    'email' => $request->email,
		    'role_id' => $request->role_id,
		    'name' => $request->name,
		    'status_id' => UserStatus::where('name', 'Pending Activation')->first()->id
		];

		$user = User::create($data);

		return $user;
	}

	/**
	 * This method gets a single user with given ID
	 *
	 * @param  int  $id The id of the user
	 */
	public function getUser($id)
	{
		$user = User::with('status', 'role')->find($id);

		return $user;
	}

    /**
     * Update a given user with given data
     * 
     * @param  App\Models\User $user The user to update
     * @param  Illuminate\Http\Request $request The HTTP request
     * @return App\Models\User The updated user
     */
	public function updateUser($user, $request)
	{
		$data = [];

		$editables = ['name', 'email', 'password', 'status_id', 'role_id'];

		foreach ($editables as $editable) {
			if($request->has($editable)) {
				if ($editable == 'password') {
					$data[$editable] = Hash::make($request->password);
				} else {
					$data[$editable] = $request->$editable;
				}
			}
		}

		$user->update($data);

		return $user;
	}

    /**
     * Delete the given user
     * 
     * @param  App\Models\User $user The user to be deleted
     */
	public function delete($user)
	{
		$user->delete();
	}

    /**
     * Activate a user account by updating password after been added by admin
     * 
     * @param  App\Models\User $user The user whose account is being activated
     * @param  Illuminate\Http\Request $request The HTTP request
     * @return App\Models\User The updated user
     */
	public function activateUser($user, $request)
	{
		// Update user account
        $user->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'status_id' => UserStatus::where('name', 'active')->first()->id,
        ]);
	}
}