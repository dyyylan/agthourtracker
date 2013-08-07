<?php

class AdditionalCostCode extends Eloquent {
	
	protected $table = 'agthourtracker_additional_costcodes';

	public function project() { return $this->belongsTo('AdditionalProject', 'project_id'); }

}