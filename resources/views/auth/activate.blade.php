@extends('layouts.app')
	
@section('title')
	Login
@endsection

@section('content')
	<div class="row">
		<div id="login-wrapper" class="animated fadeIn col-lg-4 col-md-4 col-sm-6 col-xs-8 col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-2">

			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-8 col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-xs-offset-2">
					<img id="login-logo" class="img-responsive" src="{{ URL::asset('images/logo.png') }}">
					<h1 class="align_center"><b>Ezi Pharmacy</b></h1>		
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<h3 class="align_center">Activate Account</h3>
					<p id="undertext" class="align_center">Activate your account by entering a new password</p>

					<form action="{!! URL::to('/activate') !!}" method="post">
						{!! csrf_field() !!}

						@include('errors.form_errors')

						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" name="username" placeholder="Username" class="form-control" required="required" autocomplete="off" readonly="readonly" value="{{ Auth::user()->username }}">
						</div>

						<div class="form-group">
							<label for="username">Full Name</label>
							<input type="text" name="name" placeholder="Enter Full Name" class="form-control" required="required" autocomplete="off" value="{{ Auth::user()->name }}">
						</div>

						<div class="form-group">
							<label for="password">Password</label>		
							<input type="password" name="password" placeholder="Enter New Password" class="form-control" required="required" autocomplete="off">
						</div>

						<div class="form-group">
							<label for="password_confirmation">Password Confirmation</label>		
							<input type="password" name="password_confirmation" placeholder="Confirm New Password" class="form-control" required="required" autocomplete="off">
						</div>

						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<input type="submit" name="submit" value="Activate Account" class="btn btn-lg btn-block btn-success">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<style>
		div.container {
			padding: 10px;
		}
	</style>
@endsection