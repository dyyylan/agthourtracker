@section('content')
<h1>New User</h1>

<form method="post" action="/users/new">
<input type="hidden" name="_token" value="{{ csrf_token() }}" />

<div class="field">
	<label for="fname">Name:</label>
	<input type="text" name="fname" id="fname" placeholder="First" required="required" />
	<input type="text" name="lname" id="lname" placeholder="Last" required="required" />
</div>

<div class="field">
	<label for="email">Email address:</label>
	<input type="email" name="email" id="email" required="required" />
</div>

<div class="field">
	<label for="password">Password:</label>
	<input type="password" name="password" id="password" required="required" />
</div>

<div class="field">
	<label for="receive_emails" class="checkbox inline">
		<input type="checkbox" name="receive_emails" id="receive_emails" value="yes" checked="checked" />
		Receive email reminders	
	</label>
</div>

<br />

<div class="actions">
	<input type="submit" value="Create User" />
</div>

</form>

@stop