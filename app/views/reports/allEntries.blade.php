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
			@if (Auth::user()->is_admin)
				<th></th>
			@endif
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
			@if (Auth::user()->is_admin)
				<td>
					<form method="post" action="/entries/delete">
						<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
						<input type="hidden" name="id" value="{{ $entry->id }}" />
						<input type="submit" value="delete" class="btn btn-small" onclick="return confirm('Are you sure you want to delete this entry?');" />
					</form>
				</td>
			@endif
		</tr>
	@endforeach

	</tbody>
</table>

{{ $entries->links() }}

@stop