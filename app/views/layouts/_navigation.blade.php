<ul class="nav">

	@if (Auth::user())
		<li><a href="/">Home</a></li>
	
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Time Entry <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="/entries/calendar">My calendar</a></li>
				<li><a href="/entries/new">Single time entry</a></li>
				<li><a href="/entries">View my hours</a></li>
			</ul>
		</li>

		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="/reports">All reports</a></li>
				<li><a href="/reports/weekly/overview">Weekly reports</a></li>
				<li><a href="/reports/jobcosts">Job costs report</a></li>
				<li><a href="/reports/jobhours">Job hours report</a></li>
			</ul>
		</li>

		@if (Auth::user()->is_admin)
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Administration <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="/users">User management</a></li>
					<li><a href="/projects">Manage projects</a></li>
				</ul>
			</li>
		@endif
	@endif
</ul>