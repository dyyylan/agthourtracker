@section('content')

<h1>Create New Entry</h1>
<p>Enter the appropriate information to submit a new time entry.</p>

<div class="well">

<form method="post" action="/entries/new">
<input type="hidden" name="_token" value="<?= csrf_token() ?>" />

<div class="field">
	<label for="date">Date:</label>
	<input type="date" name="date" id="date" value="<?= date('Y-m-d') ?>" />
</div>

<div class="field">
	<label for="hours">Duration:</label>
	<select name="hours" id="hours">
		<option value="0">Hours</option>
		<?php for ($i = 0; $i < 13; $i++): ?>
			<option value="<?= $i ?>"><?= $i ?> hours</option>
		<?php endfor; ?>
	</select>
	<select name="minutes" id="minutes">
		<option value="0">Minutes</option>
		<?php for ($i = 0; $i < 60; $i+=15): ?>
			<option value="<?= $i ?>"><?= $i ?> minutes</option>
		<?php endfor; ?>
	</select>
</div>

<div class="field">
	<label for="job_number">Job number:</label>
	<select name="job_number" id="job_number">
		<option value="">Select...</option>
		@foreach ($jobNumbers as $jobNumber)
			<option value="{{ $jobNumber->jobnumber }}">{{ $jobNumber->jobnumber }} :: {{ $jobNumber->projectdescription }}</option>
		@endforeach
	</select>
</div>

<div class="field">
	<label for="cost_code">Cost code:</label>
	<select name="cost_code" id="cost_code">
		<option value="">Select...</option>
		@foreach ($costCodes as $costCode)
			<option value="{{ $costCode->costcode }} :: {{ $costCode->costcodedesc }}">
				{{ $costCode->costcode }} :: {{ $costCode->costcodedesc }}
			</option>
		@endforeach
	</select>
</div>

<button class="btn btn-primary">Add Entry</button>

</form>
</div>

@stop