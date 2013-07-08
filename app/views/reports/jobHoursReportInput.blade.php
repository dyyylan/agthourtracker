@section('content')

<h1>Job Hours Report</h1>
<p>This report displays all hours associated with a particular project.</p>
<p>Select a job number from the list below to generate the report. <em>(Note: only projects with hours are shown below)</em></p>

<form method="post" action="/reports/jobhours" class="well">
<input type="hidden" name="_token" value="{{ csrf_token() }}" />

<div class="field">
	<label for="job_number">Job number:</label>
	<select name="job_number" id="job_number">
		@foreach ($jobNumbers as $jobNumber)
			<option value="{{ $jobNumber->job_number }}">{{ $jobNumber->job_number }}</option>
		@endforeach
	</select>
</div>

<div class="actions">
	<input type="submit" value="Generate Report" class="btn btn-primary" />
</div>

</form>

@stop