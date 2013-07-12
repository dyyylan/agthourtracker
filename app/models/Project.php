<?php

class Project extends Eloquent {
	
	protected $table = 'projects_agtcan';

	public function costCodes() { return $this->hasMany('CostCode', 'project_id'); }

}