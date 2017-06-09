{{-- Add Modal --}}
<div class="modal fade custom-modal" id="add">
	<div class="modal-dialog">
		<form role="form" class="modal-content" action="{{ URL::to('/users') }}" method="post" id="user-add-form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">x</span>
                </button>

                <h4>Add New User</h4>
            </div>
            
			<div class="modal-body">
	            <div id="users-add-errors-container">
                    @include('partials.modal_errors')
                </div>

				<div class="row">
					<div class="col-lg-10 col-md-10 col-sm-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
						{!! csrf_field() !!}

						<!-- This is the name field -->
						<div class="form-group">
							<label for="username">Username</label>
							<input  type         = "text"
									class        = "form-control" 
									id           = "username" 
									name         = "username"
									placeholder  = "Username"
									autocomplete = "off">
						</div>

						<div class="form-group">
							<label for="name">Name</label>
							<input  type         = "text"
									class        = "form-control" 
									id           = "name" 
									name         = "name"
									placeholder  = "Full Name"
									autocomplete = "off">
						</div>

						<div class="form-group">
							<label for="password">Password</label>
							<input  type         = "password"
									class        = "form-control" 
									id           = "password" 
									name         = "password"
									placeholder  = "Password"
									autocomplete = "off">
						</div>

						<div class="form-group">
							<label for="password_confirmation">Confirm Password</label>
							<input  type         = "password"
									class        = "form-control" 
									id           = "password_confirmation" 
									name         = "password_confirmation"
									placeholder  = "Confirm Password"
									autocomplete = "off">
						</div>

						<div class="form-group">
							<label for="email">Email</label>
							<input  type         = "text"
									class        = "form-control" 
									id           = "email" 
									name         = "email"
									placeholder  = "Email"
									autocomplete = "off">
						</div>

						<div class="form-group">
							<label for="role_id">Role</label>

							<select name="role_id" class="form-control">
								<option value="">Select A Role</option>

								@foreach ($roles as $role)
									<option value="{{ $role->id }}">{{ $role->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6">
						<button type="submit" class="btn btn-primary btn-block">Add User</button>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-6">
						<button type="button" class=" btn btn-default btn-block" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

{{-- Edit Modal --}}
<div class="modal fade custom-modal" id="user-edit">
	<div class="modal-dialog">
		<form role="form" class="modal-content" method="post" id="user-update-form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">x</span>
                </button>

                <h4>Update Account</h4>
            </div>
            
			<div class="modal-body">
	            <div id="users-add-errors-container">
                    @include('partials.modal_errors')
                </div>

				{!! csrf_field() !!}
				<input type="hidden" name="_method" value="PUT">
				<input type="hidden" name="admin_edit" value="true">

				<div class="form-group">
					<label for="username">Username</label>
					<input  type         = "text"
							class        = "form-control" 
							id           = "username" 
							name         = "username"
							placeholder  = "Username"
							readonly     = "readonly" 
							autocomplete = "off">
				</div>

				<div class="form-group">
					<label for="name">Name</label>
					<input  type         = "text"
							class        = "form-control" 
							id           = "name" 
							name         = "name"
							placeholder  = "Full Name"
							autocomplete = "off">
				</div>

				<div class="form-group">
					<label for="name">Email</label>
					<input  type         = "text"
							class        = "form-control" 
							id           = "email" 
							name         = "email"
							placeholder  = "Email"
							autocomplete = "off">
				</div>

				<div class="form-group>
					<label for="password">Password</label>
					<input  type         = "password"
							class        = "form-control" 
							id           = "password" 
							name         = "password"
							placeholder  = "Only for resetting password"
							autocomplete = "off">
				</div>

				<div class="form-group">
					<label for="password_confirmation">Confirm Password</label>
					<input  type         = "password"
							class        = "form-control" 
							id           = "password_confirmation" 
							name         = "password_confirmation"
							placeholder  = "Confirm new password"
							autocomplete = "off">
				</div>

				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6">
						<div class="form-group">
							<label for="role_id">Role</label>

							<select name="role_id" class="form-control">
								<option value="">Select A Role</option>

								@foreach ($roles as $role)
									<option value="{{ $role->id }}">{{ $role->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-6">
						<div class="form-group">
							<label for="status_id">Status</label>

							<select id="status_id" name="status_id" class="form-control">
								<option value="">Select User's Status</option>

								@foreach ($statuses as $status)
									<option value="{{ $status->id }}">{{ $status->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6">
						<button type="submit" class="btn btn-info btn-block">Update Account</button>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-6">
						<button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>