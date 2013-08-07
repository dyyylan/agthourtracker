<?php

class AdditionalProject extends Eloquent {

	protected $table = 'agthourtracker_additional_projects';

	public function costCodes() { return $this->hasMany('AdditionalCostCode', 'project_id'); }

}