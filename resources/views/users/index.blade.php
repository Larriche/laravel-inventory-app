@extends('layouts.app')

@section('title')
	Manage Users
@endsection

@section('page_title')
	Manage Users
@endsection

@section('content')
	<div class="row">
	    <div class="col-sm-12 col-md-12 col-lg-12">
	        <div class="x_panel animated fadeIn">
	             <div class="x_title">
	                 <div class="row">
	                     <div class="col-lg-12 col-md-12 col-sm-12">
	                     	<button class="btn btn-primary pull-right" data-toggle="modal" data-target="#add"><i class="fa fa-user-plus"></i> Add New User</button>

							<p class="undertext">You can add, update and/or deactivate users accounts.</p>
	                     </div>
	                 </div>
	             </div>

	            <div class="x_content">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							@include('errors.form_errors')
							
							<div id="users-container">
								@include('users.table', [
									'roles'    => $roles,
									'users'    => $users,
									'statuses' => $statuses,
								])
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('users.modals', [
		'roles'    => $roles,
		'statuses' => $statuses,
	])
@endsection

@section('scripts')
	<script src="{{ URL::asset('js/users.js') }}"></script>
@endsection