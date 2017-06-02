<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Styles -->
		@include('partials.styles')
		@yield('styles')

		<title>@yield('title') | Inventory</title>
	</head>

	<?php
		$body_class = '';

		if (Request::segment(1) == 'login') {
			$body_class = 'login-page';
		} else if (Request::segment(1) == 'activate') {
			$body_class = 'activation-page';
		}
	?>

	<body class="nav-md {{ $body_class }}">
		<div class="container body">
			<div class="main_container">
				@if (Auth::check())
					{{-- Sidebar --}}
					<div class="col-lg-3 col-md-3 col-sm-3 left_col">
						@include('partials.sidebar')
					</div>

					{{-- Top Navigation --}}
					<div class="top_nav">
						@include('partials.nav')
					</div>

					<!-- page content -->
					<div class="right_col" role="main">
						<div class="page-title">
							<div class="title_center">
								<h1 class="animated fadeInDown">@yield('page_title')</h1>
							</div>
						</div>

						<div class="clearfix"></div>

						<div id="content">
							@yield('content')
						</div>
					</div>

					<footer>
						<div class="pull-right">
							<p>&copy; {{ date('Y') }} - Inventory</p>
						</div>

						<div class="clearfix"></div>
					</footer>
				@else
					@yield('content')
				@endif
			</div>
		</div>
		
         @include('partials.confirm_dialog')
         
		{{-- Scripts --}}
		@include('partials.scripts')
		@yield('scripts')
	</body>
</html>
