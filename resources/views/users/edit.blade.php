@extends('layouts.app')

@section('title')
	My Account
@endsection

@section('page_title')
	My Account
@endsection

@section('content')
	<div class="row">
	    <div class="col-sm-12 col-md-12 col-lg-12">
	        <div class="x_panel">
	             <div class="x_title">
	                 <div class="row">
	                     <div class="col-lg-12 col-md-12 col-sm-12">
							<p class="undertext">You can edit your profile here. You can also change your password too.</p>
	                     </div>
	                 </div>
	             </div>

	            <div class="x_content">
					<div class="row">
						<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-3 col-md-offset-2 col-sm-offset-1 animated fadeIn" >
							<form role="form" action="{{ url('/users/'. Auth::user()->id) }}" method="post" id="user-account-form">
								@include('errors.form_errors')

								<div id="account-errors-container">
				                    @include('partials.modal_errors')
				                </div>
								<input type="hidden" name="_method" value="PUT">

								{!! csrf_field() !!}

								<div class="form-group">
									<label for="username">Username</label>
									<input  type        = "text"
											class       = "form-control" 
											id          = "username" 
											name        = "username"
											value       = "{{ $user->username }}"
											data-role   = "{{ $user->role->id }}"
											readonly>
								</div>

								<div class="form-group">
									<label for="name">Name</label>
									<input  type         = "text"
											class        = "form-control" 
											id           = "name" 
											name         = "name"
											placeholder  = "Full name"
											value        = "{{ $user->name }}"
											disabled     = "disabled" 
											autocomplete = "off">
								</div>

								<div class="form-group">
									<label for="email">Email</label>
									<input  type         = "text"
											class        = "form-control" 
											id           = "email" 
											name         = "email"
											placeholder  = "Email"
											value        = "{{ $user->email }}"
											disabled     = "disabled" 
											autocomplete = "off">
								</div>

								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="form-group">
											<label>Role</label>
											<input  type     = "text"
													class    = "form-control" 
													value    = "{{ $user->role->name }}"
													readonly>
										</div>
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="form-group">
											<label>Status</label>
											<input  type     = "text"
													class    = "form-control"
													value    = "{{ $user->status->name }}"
													readonly>
										</div>
									</div>
								</div>

								<div class="form-group hidden password_editable">
									<label for="password">New password</label>
									<input  type        = "password"
											class       = "form-control" 
											id          = "password" 
											name        = "password"
											placeholder = "New password"
											autocomplete = "off">
								</div>

								<div class="form-group hidden password_editable">
									<label for="password_confirmation">Confirm new password</label>
									<input  type        = "password"
											class       = "form-control" 
											id          = "password_confirmation" 
											name        = "password_confirmation"
											placeholder = "Re-type new password"
											autocomplete = "off">
								</div>
								
								<div class="form-group hidden validate_user">
									<label for="old_password">Specify current password</label>
									<input  type        = "password"
											class       = "form-control" 
											id          = "old_password" 
											name        = "old_password"
											placeholder = "Current password"
											autocomplete = "off">
								</div>
									
								<div class="form-group hidden editable">
									<input  type        = "submit"
											class       = "btn btn-info form-control"
											value       = "UPDATE ACCOUNT">
								</div>

								<div class="form-group hidden editable">
									<input  type    = "button"
											id      = "change_password"
											onclick = "Users.enableChangePassword(this); return false;"
											class   = "btn btn-danger form-control" 
											value   = "CHANGE PASSWORD">
								</div>

								<div class="form-group">
									<input  type    = "button"
											onclick = "Users.enableUserEdit(this); return false;"
											class   = "btn btn-warning form-control" 
											value   = "EDIT ACCOUNT">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ URL::asset('js/users.js') }}"></script>
@endsection