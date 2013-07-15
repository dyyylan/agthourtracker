@section('content')

<h1>Create New Entry</h1>
<p>Enter the appropriate information to submit a new time entry.</p>

<div class="well">

<form method="post" action="/entries/new">
<input type="hidden" name="_token" value="{{ csrf_token() }}" />

<div class="field">
	<label for="date">Date:</label>
	<input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" />
</div>

<div class="field">
	<label for="hours">Duration:</label>
	<select name="hours" id="hours">
		<option value="0">Hours</option>
		@for ($i = 0; $i < 13; $i++)
			<option value="{{ $i }}">{{ $i }} hours</option>
		@endfor
	</select>
	<select name="minutes" id="minutes">
		<option value="0">Minutes</option>
		@for ($i = 0; $i < 60; $i += 15)
			<option value="{{ $i }}">{{ $i }} minutes</option>
		@endfor
	</select>
</div>

<div class="field">
	<label for="job_number">Job number:</label>
	<select name="job_number" class="jobnumber" id="jobnumber_1">
		<option value="">Select...</option>
		@foreach ($jobNumbers as $jobNumber)
			<option value="{{ $jobNumber->project_number }}">{{ $jobNumber->project_number }} :: {{ $jobNumber->description }}</option>
		@endforeach
	</select>
</div>

<div class="field">
	<label for="cost_code">Cost code:</label>
	<img src="/assets/img/ajax-loader.gif" id="loader_1" class="butterbox" />
	<select name="cost_code" id="costcode_1">
		<option value="">Select...</option>
		@foreach ($costCodes as $costCode)
			<option value="{{ $costCode->cost_code }} :: {{ $costCode->description }}">
				{{ $costCode->cost_code }} :: {{ $costCode->description }}
			</option>
		@endforeach
	</select>
</div>

<button class="btn btn-primary">Add Entry</button>

</form>
</div>

@stop