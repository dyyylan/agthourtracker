<?php

class ProjectsController extends BaseController {

	public function getCostCodesForProject() {
		$projectNumber = Input::get('job_number');
		$project = Project::where('project_number', '=', $projectNumber)->first();
		
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

}