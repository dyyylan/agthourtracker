@section('content')
<h1>Manage cost codes for project</h1>
<p>Manage project details and cost codes for the selected project.</p>


<div class="well">
	<h3>Project information</h3>
	<table>
		<tr>
			<th class="text-left">Project number:</th>
			<td>{{$project->project_number}}</td>
		</tr>
		<tr>
			<th class="text-left">Description:</th>
			<td>{{$project->description}}</td>
		</tr>
	</table>
</div>


<div class="well">
	<h3>Cost codes</h3>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Cost code</th>
				<th>Description</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($costCodes as $costCode)
				<tr>
					<td>{{ isset($i) ? ++$i : $i = 1 }}</td>
					<td>{{ $costCode->cost_code }}</td>
					<td>{{ $costCode->description }}</td>
					<td>
						<form method="post" action="/projects/costcodes/delete" style="margin: 0" class="text-center">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="hidden" name="id" value="{{ $costCode->id }}" />
							<input type="hidden" name="project_id" value="{{ $project->id }}" />
							<button class="btn btn-primary btn-small" onClick="return confirm('Are you sure you want to delete this cost code?');"><i class="icon-remove icon-white"></i> Delete</button>
						</form>
					</td>
				</tr>
			@endforeach
			@if (!count($costCodes))
				<tr>
					<td colspan="4">
						<p class="text-center">
							<strong>No cost codes added for this project.</strong>
						</p>
					</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>


<div class="well">
	<h3>Add cost code</h3>
	<form method="post" action="/projects/costcodes/add">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<input type="hidden" name="id" value="{{ $project->id }}" />
		<p>
			<label for="cost_code">Cost code:</label>
			<input type="text" name="cost_code" id="cost_code" />
		</p>
		<p>
			<label for="description">Description:</label>
			<input type="text" name="description" id="description" />
		</p>
		<p>
			<input type="submit" value="Save Cost Code" class="btn btn-primary" />
		</p>
	</form>
</div>

<p>
	<a href="/projects">&laquo; Back to project list</a>
</p>

@stop