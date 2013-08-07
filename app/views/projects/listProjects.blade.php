@section('content')
<h1>Additional projects</h1>
<p>This application synchronizes projects (one-way) from the Microsoft Dynamics SL AGT Solar database <strong>every 15 minutes</strong>. You may add additional projects and cost codes here that do not already appear in that database.</p>

<div class="well">
	<h3>Project list</h3>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th></th>
				<th>Project number</th>
				<th>Description</th>
				<th><div class="text-center">Cost codes</div></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($projects as $project)
				<tr>
					<td>{{ isset($i) ? ++$i : $i = 1 }}</td>
					<td>{{ $project->project_number }}</td>
					<td>{{ $project->description }}</td>
					<td><div class="text-center">{{ $project->costCodes()->count() }}</div></td>
					<td>
						<div class="text-center">
							<a href="projects/edit/{{ $project->id }}" class="btn btn-small btn-primary"><i class="icon-pencil icon-white"></i> Edit</a>
						</div>
					</td>
					<td>
						<form method="post" action="/projects/delete" class="text-center" style="margin: 0">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="hidden" name="id" value="{{ $project->id }}" />
							<button class="btn btn-small btn-primary" onClick="return confirm('Are you sure you want to delete this project and its associated cost codes?');"><i class="icon-remove icon-white"></i> Delete</button>
						</form>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

<div class="well">
	<h3>Add new project</h3>
	<p>Enter the following information to create a new project:</p>
	<form method="post" action="/projects/new">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<p>
			<label for="project_number">Project number:</label>
			<input type="text" name="project_number" id="project_number" />
		</p>
		<p>
			<label for="description">Project description</label>
			<input type="text" name="description" id="description" />
		</p>
		<p>
			<input type="submit" value="Add Project" class="btn btn-primary" />
		</p>
	</form>
</div>


@stop