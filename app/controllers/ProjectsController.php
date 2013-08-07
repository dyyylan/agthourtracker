<?php

class ProjectsController extends BaseController {

	protected $layout = 'layouts.innerPage';

	public function getCostCodesForProject() {
		$this->layout = null;

		$projectNumber = Input::get('job_number');
		$project = Project::where('project_number', '=', $projectNumber)->first();
		if (!$project) {
			$project = AdditionalProject::where('project_number', '=', $projectNumber)->first();
		}
		
		$costCodes = $project->costCodes->toArray();

		if (count($costCodes)) {
			$response = array(
				'error' => false,
				'costCodes' => $costCodes
			);
		} else {
			$response = array(
				'error' => true
			);
		}

		echo json_encode($response);
	}

	public function listProjects() {
		$data = array(
			'projects' => AdditionalProject::all()
		);

		$this->layout->content = View::make('projects.listProjects', $data);
	}

	public function createProject() {
		$input = array(
			'project_number' => Input::get('project_number'),
			'description' => Input::get('description')
		);

		$rules = array(
			'project_number' => 'required',
			'description' => 'required'
		);

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			Session::flash('error', 'You have errors in one or more of your fields.');
			return Redirect::to('/projects')->withErrors($validator);
		}

		$project = new AdditionalProject;
		$project->project_number = $input['project_number'];
		$project->description = $input['description'];

		if ($project->save()) {
			$message = 'Project successfully saved.';
			$type = 'success';
		} else {
			$message = 'Error saving project.';
			$type = 'error';
		}

		Session::flash($type, $message);
		return Redirect::to('/projects');
	}

	public function deleteProject() {
		$id = Input::get('id');
		$project = AdditionalProject::find($id);

		if (!$project) {
			Session::flash('notice', 'A project with that id cannot be found.');
			return Redirect::to('/projects');
		}

		// Foreign key constraint should exist, so cost codes will be deleted also
		if ($project->delete()) {
			$type = 'success';
			$message = 'Project successfully deleted';
		} else {
			$type = 'error';
			$message = 'Error deleting project.';
		}

		Session::flash($type, $message);
		return Redirect::to('/projects');
	}

	// This is for editing cost codes for the project
	public function editProject($id) {
		$project = AdditionalProject::find($id);
		if (!$project) {
			Session::flash('notice', 'Project not found.');
			return Redirect::to('/projects');
		}

		$costCodes = $project->costCodes;

		$data = array(
			'project' => $project,
			'costCodes' => $costCodes
		);

		$this->layout->content = View::make('projects.costCodes', $data);
	}

	// Add cost code to project
	public function addCostCode() {
		$id = Input::get('id');

		$project = AdditionalProject::find($id);

		if (!$project) {
			Session::flash('notice', 'Project not found.');
			return Redirect::to('/projects');
		}

		$input = array(
			'cost_code' => Input::get('cost_code'),
			'description' => Input::get('description')
		);

		$rules = array(
			'cost_code' => 'required',
			'description' => 'required'
		);

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			Session::flash('error', 'You have errors in one or more of your fields.');
			return Redirect::to('/projects/edit/'.$id)->withErrors($validator);
		}

		$costCode = new AdditionalCostCode;
		$costCode->cost_code = $input['cost_code'];
		$costCode->description = $input['description'];

		if ($project->costCodes()->save($costCode)) {
			$type = 'success';
			$message = 'Cost code added successfully.';
		} else {
			$type = 'error';
			$message = 'Error adding cost code.';
		}

		Session::flash($type, $message);
		return Redirect::to('/projects/edit/'.$id);
	}

	public function deleteCostCode() {
		$projectId = Input::get('project_id');
		$id = Input::get('id');
		$costCode = AdditionalCostCode::find($id);

		if (!$costCode) {
			Session::flash('notice', 'Cost code not found.');
			return Redirect::to('/projects/edit/'.$projectId);
		}

		if ($costCode->delete()) {
			$type = 'success';
			$message = 'Cost code deleted successfully.';
		} else {
			$type = 'error';
			$message = 'Error deleting cost code.';
		}

		Session::flash($type, $message);
		return Redirect::to('/projects/edit/'.$projectId);
	}

}