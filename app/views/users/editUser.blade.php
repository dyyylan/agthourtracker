@section('content')
<h1>Edit user: {{ $user->fname }} {{ $user->lname }}</h1>

<div class="well">
<form method="post" action="/users/edit/{{ $user->id }}">
<input type="hidden" name="_token" value="{{ csrf_token() }}" />

<div class="field">
	<label for="password">New Password:</label>
	<input type="password" name="password" id="password" />
</div>

@if (Auth::user()->is_admin)
	<div class="field">
		<label for="location">Location:</label>
		<select name="location" id="location">
			<option value="Canada" {{ $user->location == 'Canada' ? 'selected="selected"' : '' }}>
				Canada
			</option>
			<option value="USA" {{ $user->location == 'USA' ? 'selected="selected"' : '' }}>
				USA
			</option>
		</select>
	</div>

	<div class="field">
		<label for="is_active" class="checkbox inline">
			<input type="checkbox" name="is_active" id="is_active" value="yes" {{ $user->is_active ? 'checked="checked"' : '' }}/>
			Active
		</label>
	</div>

	<div class="field">
		<label for="receive_emails" class="checkbox inline">
			<input type="checkbox" name="receive_emails" id="receive_emails" value="yes" {{ $user->receive_emails ? 'checked="checked"' : '' }}/>
			Receive emails
		</label>
	</div>

	<div class="field">
		<label for="is_admin" class="checkbox inline">
			<input type="checkbox" name="is_admin" id="is_admin" value="yes" {{ $user->is_admin ? 'checked="checked"' : '' }}/>
			Administrator
		</label>
	</div>
@endif

<br />

<button class="btn btn-primary">Update User</button>


</form>
</div>
@stop