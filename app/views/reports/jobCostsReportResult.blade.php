@section('content')

<h1>Job Costs Report</h1>
<p>View a breakdown per project, detailing the total cost for each based on the employee's time entries.</p>

<div class="well">
	<h3 style="margin-top: -5px;">Calculated Values:</h3>
	<p>
		<strong class="label">Pay period</strong> {{ date('F jS, Y', strtotime($startDate)) }} to {{ date('F jS, Y', strtotime($endDate)) }}
	</p>
	<p>
		<strong class="label">Calculated hourly rate:</strong> ${{ number_format($hourlyRate, 3) }}
	</p>
</div>

<table class="table table-bordered table-hover job-costs-report">
	<tr class="info">
		<td><strong>#</strong></td>
		<td><strong>Name</strong></td>
		<td><strong>Date</strong></td>
		<td><strong>Job number</strong></td>
		<td><strong>Cost code</strong></td>
		<td><strong>Hours</strong></td>
		<td><strong>Cost</strong></td>
	</tr>

	@foreach ($entries as $entry)
		<tr>
			<td>{{ (isset($i)) ? ++$i : $i = 1 }}</td>
			<td>{{ $userName }}</td>
			<td>{{ date('m/d/Y', strtotime($entry->date)) }}</td>
			<td>{{ $entry->job_number }}</td>
			<td>{{ $entry->cost_code }}</td>
			<td>{{ $entry->hours }}</td>
			<td>${{ number_format($entry->hours * $hourlyRate, 2) }}</td>
		</tr>
	@endforeach

	@foreach ($totals as $jobNumber => $total)
		<tr>
			<td></td>
			<td><strong>{{ $userName }}</strong></td>
			<td><strong>Total</strong></td>
			<td>{{ $jobNumber }}</td>
			<td></td>
			<td>{{ number_format($total, 2) }}</td>
			<td>${{ number_format($total * $hourlyRate, 2) }}</td>
		</tr>
	@endforeach

	@foreach ($prpsal as $week => $hours)
		<tr>
			<td></td>
			<td><strong>{{ $userName }}</strong></td>
			<td><strong>Total</strong></td>
			<td><strong>PRPSAL</strong></td>
			<td>Week {{ $week + 1 }}</td>
			<td>{{ number_format($hours, 2) }}</td>
			<td>${{ number_format($hours * $hourlyRate, 2) }}</td>
		</tr>
	@endforeach	

	<tr>
		<td></td>
		<td><strong>{{ $userName }}</strong></td>
		<td colspan="3"><strong>Grand total</strong></td>
		<td><strong>{{ $calculatedHours }}</strong></td>
		<td><strong>${{ number_format($calculatedHours * $hourlyRate, 2) }}</strong></td>
	</tr>
</table>

<p><a href="/reports" class="btn">&laquo; Back to reports overview</a></p>

@stop