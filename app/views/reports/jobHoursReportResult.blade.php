@section('content')

<h1>Job Hours Report</h1>
<p>Displaying all hours by user for the selected job number. Click on an entry to view more detail.</p>
<h3>Displaying results for job number {{ $jobNumber }}</h3>


<table class="table table-bordered job-hours-report">
	<tr class="info">
		<td class="text-center">
			<strong>#</strong>
		</td>
		<td><strong>Name</strong></td>
		<td><strong>Hours</strong></td>
	</tr>

	@foreach ($report as $report)
		<tr class="show-hours" data-userid="{{ $report['user']->id }}">
			<td class="text-center">
				{{ (isset($i)) ? ++$i : $i = 1 }}
			</td>
			<td>{{ $report['user']->getFullName() }}</td>
			<td>{{ $report['hours'] }}</td>
		</tr>

		<tr id="hours-user-{{ $report['user']->id }}" style="display: none">
			<td colspan="3">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Date</th>
							<th>Cost Code</th>
							<th>Hours</th>
						</tr>
					</thead>

					<tbody>
						@foreach ($report['entries'] as $entry)
							<tr class="info">
								<td><small>{{ date('n/j/Y', strtotime($entry->date)) }}</small></td>
								<td><small>{{ $entry->cost_code }}</small></td>
								<td><small>{{ $entry->hours }}</small></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</td>
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