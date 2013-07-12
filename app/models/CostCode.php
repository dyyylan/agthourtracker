<?php

class CostCode extends Eloquent {
	
	protected $table = 'costcodes_agtcan';

	public function project() { return $this->belongsTo('Project', 'project_id'); }

}