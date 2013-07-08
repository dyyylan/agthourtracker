<?php

class Entry extends Eloquent {

	protected $table = 'agthourtracker_entries';

	public function user() { return $this->belongsTo('User'); }

	// Reporting methods

	// Calculate the closest previous Monday to start the report from
	// @param $startDate date 'Y-m-d' format to start from. If null,
	// start from today
	// @return 'Y-m-d' string
	public static function startDateForReport($startDate = null) {
		if (!$startDate) {
			$startDate = date('Y-m-d');
		}

		$dayOfWeek = date('N', strtotime($startDate));

		if ($dayOfWeek !== 1) {
			$daysUntilMonday = $dayOfWeek - 1;
			$startDate = date('Y-m-d', strtotime('-'.$daysUntilMonday.' days', strtotime($startDate)));
		}

		return $startDate;
	}

	// Calculate the end date for selected start date
	// @param $startDate 'Y-m-d' date string to start from
	// @return start date + 7 days
	public static function endDateForReport($startDate) {
		$endDate = strtotime('+6 days', strtotime($startDate));
		return date('Y-m-d', $endDate);
	}

}