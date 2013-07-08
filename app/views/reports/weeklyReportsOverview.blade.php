@section('content')

<h1>Weekly Reports</h1>
<p>The primary report, showing number of entries for each week with the ability to drill down and view specific entries and adjustments for each week.</p>


<table class="table table-bordered table-hover" style="width: 60%;">
	<tr class="info">
		<td><strong>Week Of:</strong></td>
		<td>
			<div class="text-center">
				<strong>Entries:</strong>
			</div>
		</td>
		<td></td>
	</tr>

	@foreach ($reports as $report)
		<tr>
			<td>{{ date('F jS, Y', strtotime($report['startDate'])) }}</td>
			<td>
				<div class="text-center">
					{{ $report['numEntries'] }}
				</div>
			</td>
			<td>
				<div class="text-center">
					<a href="/reports/weekly?startDate={{ $report['startDate'] }}" class="btn btn-small btn-primary"><i class="icon-search icon-white"></i> view</a>
				</div>
			</td>
		</tr>
	@endforeach

</table>

<p><a href="/reports" class="btn">&laquo; Back to reports overview</a></p>

@stop