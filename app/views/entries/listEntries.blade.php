@section('content')

<h1>My Time Entries</h1>

<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>
				<div class="text-center">
					#
				</div>
			</th>
			<th>Date</th>
			<th>Hours</th>
			<th>Job Number</th>
			<th>Cost Code</th>
		</tr>
	</thead>

	<tbody>
		<?php $displayed = false; ?>
		@foreach($entries as $entry)
			@if ($entry->date < date('Y-m-d', strtotime('today ' . -(date('N') - 1) . ' days')) && !$displayed)
				<tr class="info">
					<td colspan="5">
						<div class="text-center">
							Total time this week: 
							<strong>{{ $hoursThisWeek }} hour{{ $hoursThisWeek > 1 || $hoursThisWeek === 0 ? 's' : '' }}</strong>.&nbsp;
							<a href="/entries/calendar" class="btn btn-small btn-primary"><i class="icon-search icon-white"></i> View calendar</a>
						</div>
					</td>
				</tr>
				<?php $displayed = true; ?>
			@endif
			<tr>
				<td>
					<div class="text-center">
						{{ isset($i) ? ++$i : $i = 1 }}
					</div>
				</td>
				<td>{{ date('m/d/Y', strtotime($entry->date)) }}</td>
				<td>{{ $entry->hours }}</td>
				<td>{{ $entry->job_number }}</td>
				<td>{{ $entry->cost_code }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@stop