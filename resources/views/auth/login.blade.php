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
					<h1 class="align_center"><b>Inventory</b></h1>		
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<h2 class="align_center">Log in</h2>
					<p id="undertext" class="align_center">Please enter your admin credentials</p>

					<form action="{!! URL::to('/login') !!}" method="post">
						{!! csrf_field() !!}

						@include('errors.form_errors')

						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" name="username" placeholder="Username" class="form-control" required="required" autocomplete="off">
						</div>


						<div class="form-group">
							<label for="password">Password</label>		
							<input type="password" name="password" placeholder="Password" class="form-control" required="required" autocomplete="off">
						</div>

						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<input type="submit" name="submit" value="Log in" class="btn btn-lg btn-block btn-success">
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