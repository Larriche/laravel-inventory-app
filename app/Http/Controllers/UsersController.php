<?php

namespace App\Http\Controllers;

use Hash;
use Auth;
use URL;
use Response;
use Validator;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use App\Models\UserStatus;

use App\Http\Requests;
use App\Services\UsersService;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * An instance of the UsersService class for managing operations regarding users
     * 
     * @var App\Services\UsersService
     */
    private $users_service;

    /**
     * Create a new users controller instance.
     *
     * @return void
     */
    public function __construct(UsersService $users_service)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['index']]);
        $this->users_service = $users_service;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rules = [
            'role_id' => 'numeric',
            'status_id' => 'numeric'
        ];

        // Validate the passed data using the rules
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = ['errors' => $validator->messages()];

            return Response::json($response , 422);
        }

        $roles = Role::all();
        $statuses = UserStatus::all();

        $users = $this->users_service->getUsers($request);
        $data = [
            'users'     => $users, 
            'roles'     => $roles,
            'role_id'   => $request->has('role_id') ? $request->role_id: '', 
            'statuses'  => $statuses,
            'status_id' => $request->has('status_id') ? $request->status_id : '',
        ];

        if ($request->ajax()) {
            return view('users.table', $data)->render();
        }

        return view('users.index', $data)->render();
    }

    /**
     * Add a new user
     * 
     * @param  Request $request The HTTP request
     * @return Illuminate\Http\Response 
     */
    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|min:3',
            'email' => 'required|email',
            'name' => 'required|min:2|max:255',
            'password' => 'required|confirmed',
            'role_id' => 'required'
        ];

        $errorMessages = [
            'role_id.required' => 'The user role field is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $errorMessages);

        if ($validator->fails()) {
            $response = ['errors' => $validator->messages()];

            return Response::json($response, 422);
        }

        $user = $this->users_service->addUser($request);

        if ($user) {
            $response = ['message' => 'User has been added'];

            return Response::json($response, 200);   
        } else {
            $response = ['errors' => 'An unknown error occurred when adding new user'];

            return Response::json($response, 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id='')
    {     
        // For account management page
        if ($request->ajax()) {
            $user = $this->users_service->getUser($id);
            $isActivated = $user->isActivated();

            if (is_null($user)) {
                return ['errors' => ['There is no user with such ID']];
            }

            $response =  [
                'user' => $user, 
                'is_activated' => $isActivated
            ];

            return Response::json($response, 200);
        }

        // This is for my account page
        $user = User::find(Auth::user()->id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the user with the given id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->users_service->getUser($id);

        if (is_null($user)) {
            if ($request->ajax()) {
                $response = ['errors' => ['This user does not exist']];

                return Response::json($response, 422);
            }

            return redirect()->back()->withErrors('There is no user with such ID.');
        }

        // Rules for validating data
        $rules = [
            'username' => 'required|min:3',
            'email' => 'required|email',
            'name' => 'required|min:2|max:255',
        ];     
        
        // If a change in password is requested
        if ($request->has('password')) {
            $rules['password'] = 'confirmed|min:6';

            // If the user is not admin, current password must be entered
            if (!$request->has('admin_edit')) {
                $rules['old_password'] = 'required'; 
            }
        }

        // If there is an email, it must be valid and unique
        if ($request->has('email')) {
            $rules['email'] = 'email|unique:users,email,'.$user->id;
        }

        // These are the special error messages 
        $errorMessages = [
            'password.required' => 'The new password field is required.',
            'role_id.required' => 'The user role field is required.',
            'status_id.required' => 'The user status field is required.',
            'password.confirm'  => 'The new password confirmation does not match.',
            'password.min'      => 'The new password must be at least 6 characters.',
            'old_password.required' => 'The current password field is required.',
        ];

        // Validating the request
        $validator = Validator::make($request->all(), $rules, $errorMessages);

        // If validations fail go back to the form with the errors
        if ($validator->fails()) {
            if ($request->ajax()) {
                $response = ['errors' => $validator->messages()];
                return Response::json($response, 422);
            }

            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator);
        }

        // If user wants to change the password
        if ($request->has('password')) {
            // Verify that current password is valid for the user
            if ($request->has('old_password')) {
                if (!Hash::check($request->input('old_password'), $user->password)) {
                    if ($request->ajax()) {
                        $validator->getMessageBag()->add('old_password', 'Current password is not valid');
                        $response = ['errors' => $validator->messages()];
                        return Response::json($response, 422);
                    }

                    // Redirect the user back to the previous route with the error status
                    return redirect()->back()->withErrors('Specified current password is invalid.');
                }
            }
        }

        // Update the user's account
        $this->users_service->updateUser($user, $request);

        if ($request->ajax()) {
            $response = ['message' => 'User account has been updated successfully'];
            return Response::json($response, 200);
        }
    
        // Return back to the previous page with session success
        return redirect()->back()->with('status', 'Account was updated successfully.');
    }

    /**
     * Delete the user with the given ID
     * 
     * @param int $id The ID of the user
     * @return Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $user = $this->users_service->getUser($id);

        if ($user) {
            $this->users_service->delete($user);

            $response = ['message' => 'User account has been deleted'];
            return Response::json($response, 200);
        } else {
            $response = ['errors' => ['This user does not exist']];

            return Response::json($response, 404);
        }
    }
}
