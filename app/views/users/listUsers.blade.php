@section('content')
<h1>User Management</h1>
<p>Displaying a list of all users in the system. You may edit an employee's options by clicking the link beside their name, or add a new user at the bottom of the list.</p>

<p>This page is only available to site administrators.</p>

<table class="table table-hover table-bordered">
	<tr class="info">
		<td><strong>Name</strong></td>
		<td><strong>Email</strong></td>
		<td><strong>Location</strong></td>
		<td>
			<div class="text-center">
				<strong>Receive Emails?</strong>
			</div>
		</td>
		<td>
			<div class="text-center">
				<strong>Active?</strong>
			</div>
		</td>
		<td>
			<div class="text-center">
				<strong>Administrator?</strong>
			</div>
		</td>
		<td></td>
	</tr>

	@foreach ($users as $user)
		<tr>
			<td>{{ $user->fname }} {{ $user->lname }}</td>
			<td>{{ $user->email }}</td>
			<td>{{ $user->location }}</td>
			<td>
				<div class="text-center">
					@if ($user->receive_emails)
						<div class="label label-success">
							<i class="icon-ok icon-white"></i>
						</div>
					@else
						<div class="label label-important">
							<i class="icon-remove icon-white"></i>
						</div>
					@endif
				</div>
			</td>
			<td>
				<div class="text-center">
					@if ($user->is_active)
						<div class="label label-success">
							<i class="icon-ok icon-white"></i>
						</div>
					@else
						<div class="label label-important">
							<i class="icon-remove icon-white"></i>
						</div>
					@endif
				</div>
			</td>
			<td>
				<div class="text-center">
					@if ($user->is_admin)
						<div class="label label-success">
							<i class="icon-ok icon-white"></i>
						</div>
					@else
						<div class="label label-important">
							<i class="icon-remove icon-white"></i>
						</div>
					@endif
				</div>
			</td>
			<td>
				<div class="text-center">
					<a href="/users/edit/{{ $user->id }}" class="btn btn-small btn-primary" style="padding: 3px 10px 3px 10px;"><i class="icon-pencil icon-white"></i> Manage</a>
				</div>
			</td>
		</tr>
	@endforeach

</table>

<p><a href="/users/new" class="btn btn-primary"><i class="icon-plus icon-white"></i> Add new user</a></p>

@stop