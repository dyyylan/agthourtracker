@section('content')

<h1>Log In</h1>
<p>You must be logged in to access this page. Please enter your credentials:</p>

<form method="post" action="/login" class="well">
<input type="hidden" name="_token" value="<?= csrf_token() ?>" />

<div class="field">
	<label for="email">User:</label>
	<select name="email" id="email">
		<option value=""></option>
		@foreach ($users as $user)
			<option value="{{ $user->email }}">
				{{ $user->fname }} {{ $user->lname }}
			</option>
		@endforeach
	</select>
</div>

<div class="field">
	<label for="password">Password:</label>
	<input type="password" name="password" id="password" />
</div>

<button class="btn btn-primary">Log In</button>

</form>

@stop