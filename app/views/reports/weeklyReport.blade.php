@section('content')
<h1>Weekly Report</h1>

<h3>Viewing entries for {{ date('n/j/y', strtotime($startDate)) }} to {{ date('n/j/y', strtotime($endDate)) }}</h3>	

@if (count($entries))
	<table class="table table-bordered table-hover">
		<tr class="info">
			<td><strong>User</strong></td>
			<td><strong>Date</strong></td>
			<td><strong>Hours</strong></td>
			<td><strong>Job Number</strong></td>
			<td><strong>Cost code</strong></td>
		</tr>

		@foreach ($entries as $entry)
			<tr>
				<td>{{ User::find($entry['user_id'])->fname }} {{ User::find($entry['user_id'])->lname }}</td>
				<td>{{ date('m/d/Y l', strtotime($entry['date'])) }}</td>
				<td>{{ (float) $entry['hours'] }}</td>
				<td>{{ $entry['job_number'] }}</td>
				<td>{{ $entry['cost_code'] }}</td>
			</tr>
		@endforeach

		@if (count($totals))
			@foreach ($totals as $user_id => $totalHours)
				<tr>
					<td>
						<strong>{{ User::find($user_id)->fname }} {{ User::find($user_id)->lname }}</strong>
					</td>
					<td>
						<strong>{{ date('m/d/Y', strtotime($endDate)) }}</strong>
					</td>
					<td>
						<strong>{{ 40 - $totalHours }}</strong>
					</td>
					<td>
						<strong>PRPSAL</strong>
					</td>
					<td>
						<strong>Adjustment to 40 hours</strong>
					</td>

				</tr>
			@endforeach
		@endif

	</table>
@else
	<div class="alert alert-info">
		<h4>Notice</h4>
		No records found for that date range.
	</div>
@endif

<div class="well">
	<form method="get" action="/reports/weekly" id="changeReportDate">
		<h3 style="margin-top: -10px">Options</h3>
		<label for="startDate">Select another report date:</label>
		<input type="date" name="startDate" value="{{ date('Y-m-d', strtotime($startDate)) }}" class="search-query" />
		<button class="btn"><i class="icon-search icon-white"></i> View Report</button>
	</form>

	@if (!$showUSA)
		<p>USA employees are currently <strong>hidden</strong>.</p>
		<a href="{{ Request::url() .'?'. $_SERVER['QUERY_STRING'] }}&showUSA=yes" class="btn">Show USA employees</a></p>
	@else
		<p>USA employees are currently <strong>visible</strong>.</p>
		<a href="{{ Request::url() .'?'. Request::get('startDate') }}" class="btn">Hide USA employees</a></p>
	@endif
</div>

@stop