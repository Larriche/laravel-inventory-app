<div class="nav_menu">
	<nav>
		<div class="nav toggle">
			<a id="menu_toggle"><i class="fa fa-bars"></i></a>
		</div>

		<ul class="nav navbar-nav navbar-right">
			<li class="{{ Request::segment(1) === 'logout' ? 'active' : null }}"><a href="{{ URL::to('/logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
			<li class="{{ Request::segment(1) === 'support' ? 'active' : null }}"><a href="{{ URL::to('/support') }}"><i class="fa fa-support"></i> Support</a></li>
			<li class="{{ Request::segment(1) === 'users' && is_int(Request::segment(2)) ? 'active' : null }}"><a href="{{ URL::to('/my_account') }}"><i class="fa fa-user"></i> My Account</a></li>
			<li class="{{ empty(Request::segment(1)) ? 'active' : null }}"><a href=""><i class="fa fa-home"></i> Dashboard</a></li>
		</ul>
	</nav>
</div>
