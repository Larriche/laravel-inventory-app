<div class="left_col scroll-view" style="width: 100%">
	<div class="navbar nav_title" style="border: 0;">
		<a href="{!! URL::to('/') !!}" class="site_title"></i> <span>Inventory</span></a>
	</div>

	<div class="clearfix"></div>

	<!-- menu profile quick info -->
	<div class="profile clearfix">
		<div class="profile_pic">
			<img id="profile-pic" src="{{ URL::asset('/images/logo.png') }}" class="img-circle profile_img">
		</div>

		<div class="profile_info">
			<span>Welcome</span>

			<h2>Hello {{ Auth::user()->name }}</h2>
		</div>

		<div class="clearfix"></div>
	</div>

	<br />

	<!-- sidebar menu -->
	<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
		<div class="menu_section">
			<ul class="nav side-menu">
				<li class="{{ empty(Request::segment(1)) || Request::segment(1) == 'dashboard' ? 'active' : null }}"><a href="{{ URL::to('/') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>

                <li class="{{ empty(Request::segment(1)) || Request::segment(1) == 'items' ? 'active' : null }}"><a href="{{ URL::to('/') }}"><i class="fa fa-gift"></i>Items</a></li>

                <li class="{{ empty(Request::segment(1)) || Request::segment(1) == 'types' ? 'active' : null }}"><a href="{{ URL::to('/') }}"><i class="fa fa-cubes"></i>Types</a></li>

                <li class="{{ empty(Request::segment(1)) || Request::segment(1) == 'vendors' ? 'active' : null }}"><a href="{{ URL::to('/') }}"><i class="fa fa-institution"></i>Vendors</a></li>
                
			</ul>		
		</div>

		<div class="menu_section">
			<ul class="nav side-menu">
				<li class="{{ Request::segment(1) === 'my_account' ? 'active' : null }}"><a href="{{ URL::to('/my_account') }}"><i class="fa fa-user"></i>My Account</a></li>
				<li class="{{ Request::segment(1) === 'support' ? 'active' : null }}"><a href="{{ URL::to('/support') }}"><i class="fa fa-support"></i>Support</a></li>
			</ul>
		</div>
	</div>
</div>
