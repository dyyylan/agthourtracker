@section('content')

<h1>Job Costs Report</h1>
<p>This report will calculate an employee's hours against the salary amount entered below.</p>

<div class="well">

<h3 style="margin-top: -5px;">Salary Info</h3>

<form method="post" action="/reports/jobcosts">
<input type="hidden" name="_token" value="{{ csrf_token() }}" />

<div class="field">
	<label for="user_id">Employee:</label>
	<select name="user_id" id="user_id" required="required">
		<option value="">Select...</option>
		@foreach ($users as $user)
			<option value="{{ $user->id }}">
				{{ $user->fname }} {{ $user->lname }}
			</option>
		@endforeach
	</select>
</div>

<div class="field">
	<p>Select the pay date at the end of the two-week period to be calculated:</p>
	<input type="date" name="pay_date" id="pay_date" value="{{ date('Y-m-d', strtotime('last friday')) }}" />
</div>

<div class="field">
	<label for="salary_amount">Pay amount:</label>
	$ <input type="number" name="pay_amount" id="pay_amount" step="any" required="required" />
</div>

<div class="actions">
	<input type="submit" class="btn btn-primary" value="Generate Report" />
</div>

</form>

</div>

@stop