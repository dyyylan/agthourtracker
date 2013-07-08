@section('content')

<h1>Job Hours Report</h1>
<p>Displaying all hours by user for the selected job number.</p>
<h3>Displaying results for job number {{ $jobNumber }}</h3>


<table class="table table-bordered table-hover job-hours-report">
	<tr class="info">
		<td>
			<div class="text-center">
				<strong>#</strong>
			</div>
		</td>
		<td><strong>Name</strong></td>
		<td><strong>Hours</strong></td>
	</tr>

	@foreach ($report as $report)
		<tr>
			<td>
				<div class="text-center">
					{{ (isset($i)) ? ++$i : $i = 1 }}
				</div>
			</td>
			<td>{{ $report['name'] }}</td>
			<td>{{ $report['hours'] }}</td>
		</tr>
	@endforeach

	<tr>
		<td></td>
		<th>Total</th>
		<th>{{ number_format($totalHours, 2) }}</th>
	</tr>

</table>

<p><a href="/reports/jobhours" class="btn">&laquo; Back to job number selection</a></p>

@stop