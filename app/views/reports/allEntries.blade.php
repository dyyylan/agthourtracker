@section('content')

<h1>All Entries</h1>
<p>Listing raw entries for all users.</p>

<table class="table">
	<thead>
		<tr>
			<th>id</th>
			<th>Date</th>
			<th>User</th>
			<th>Job number</th>
			<th>Cost code</th>
			<th>Hours</th>
			<th>Entered on</th>
		</tr>
	</thead>
	<tbody>

	@foreach ($entries as $entry)
		<tr>
			<td>{{ $entry->id }}</td>
			<td>{{ date('n/j/Y', strtotime($entry->date)) }}</td>
			<td>{{ $entry->user->fname }} {{ $entry->user->lname }}</td>
			<td>{{ $entry->job_number }}</td>
			<td>{{ $entry->cost_code }}</td>
			<td>{{ $entry->hours }}</td>
			<td>{{ $entry->created_at }}</td>
		</tr>
	@endforeach

	</tbody>
</table>

{{ $entries->links() }}

@stop