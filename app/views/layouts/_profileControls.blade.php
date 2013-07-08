<ul class="nav pull-right">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<i class="icon-user icon-white"></i> {{ Auth::user()->fname }} {{ Auth::user()->lname }} <b class="caret"></b>
		</a>

		<ul class="dropdown-menu">
			<li><a href="/users/edit/{{ Auth::user()->id }}">Settings</a></li>
			<li><a href="/logout" onclick="return confirm('Are you sure you want to log out?')">Log out</a></li>
		</ul>
	</li>
</ul>