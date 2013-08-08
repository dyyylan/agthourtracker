<?php

class ReportsController extends BaseController {

	protected $layout = 'layouts.innerPage';

	// Display a list of reports available to the user
	public function listReports() {
		$this->layout->content = View::make('reports.listReports');
	}

	// Display a list of all weekly reports, with summary for each week
	public function weeklyReportsOverview() {
		$this->layout->title = 'Weekly Reports';

		// Retrieve the first and last entries
		$earliestEntry = Entry::orderBy('date', 'asc')->first();
		$latestEntry = Entry::orderBy('date', 'desc')->first();

		// Calculate the start date and end dates for reports to gather
		$firstReportStartingDate = Entry::startDateForReport($earliestEntry->date);
		$lastReportStartingDate = Entry::startDateForReport($latestEntry->date);

		// Create list of reports and aggregate data
		$reports = array();
		$currentReportDate = $lastReportStartingDate;
		while ($currentReportDate >= $firstReportStartingDate) {
			$currentReportEndingDate = Entry::endDateForReport($currentReportDate);
			$numEntries = Entry::where('date', '>=', $currentReportDate)
			->where('date', '<=', $currentReportEndingDate)
			->count();
			$reports[] = array(
			'startDate' => $currentReportDate,
			'numEntries' => $numEntries
			);

			// Continue to next week's report
			$currentReportDate = date('Y-m-d', strtotime('-7 days', strtotime($currentReportDate)));
		}

		$data = array(
			'reports' => $reports
		);

		$this->layout->content = View::make('reports.weeklyReportsOverview', $data);
	}

	// Display an weekly report with hour calculations
	public function weeklyReport() {
		$this->layout->title = 'Weekly Report';

		// Select the date range for the report
		// If not date is set, defaults to this week
		$startDate = Request::get('startDate');
		$startDate = Entry::startDateForReport($startDate);
		$endDate = Entry::endDateForReport($startDate);

		// Ignore US users by default
		if (Request::get('showUSA') !== 'yes') {
			$users = User::where('location', '!=', 'USA')->get();
			$showUSA = false;
		} else {
			$users = User::all();
			$showUSA = true;
		}

		foreach ($users as $user) {
			$userEntries = $user->entries()
				->where('date', '>=', $startDate)
				->where('date', '<=', $endDate)
				->orderBy('date')
				->get()
				->toArray();
			
			if (!empty($entries)) {
				$entries = array_merge($entries, $userEntries);
			} else {
				$entries = $userEntries;
			}
		}

		// Calculate total hours to round to for each employee
		$totals = array();
		foreach($entries as $entry) {
			$user_id = $entry['user_id'];
			if (isset($totals[$user_id])) {
				$totals[$user_id] += $entry['hours'];
			} else {
				$totals[$user_id] = $entry['hours'];
			}
		}

		$data = array(
			'startDate' => $startDate,
			'endDate' => $endDate,
			'entries' => $entries,
			'totals' => $totals,
			'showUSA' => $showUSA
		);

		$this->layout->content = View::make('reports.weeklyReport', $data);
	}

	// Get user input to generate a job costs report
	public function jobCostsReportInput() {
		$users = User::orderBy('fname')->get();

		$data = array(
			'users' => $users
		);

		$this->layout->title = 'Job Costs Report';
		$this->layout->content = View::make('reports.jobCostsReportInput', $data);
	}

	// Display job cost results for the selected inputs
	public function jobCostsReportResult() {
		// Gather user input
		$userId = Input::get('user_id');
		$payAmount = Input::get('pay_amount');
		$payDate = Input::get('pay_date');

		$user = User::find($userId);

		// Calculate the starting date and ending date for the entries to gather
		// The pay period is the previous two weeks before the selected date
		$endDate = date('Y-m-d', strtotime('previous sunday', strtotime($payDate)));
		$startDate = date('Y-m-d', strtotime('previous monday -1 week', strtotime($endDate)));

		$entries = Entry::where('date', '>=', $startDate)
						->where('date', '<=', $endDate)
						->where('user_id', '=', $userId)
						->orderBy('job_number', 'asc')
						->orderBy('date', 'desc')
						->get();

		$startWeekTwo = date('Y-m-d', strtotime('previous monday', strtotime($endDate)));

		// Calculate the total hours for the pay period
		$totalHours = 0;
		$totalWeekOne = 0;
		$totalWeekTwo = 0;
		$totals = array();
		foreach ($entries as $entry) {
			$totalHours += $entry->hours;

			$jobNumber = $entry->job_number;
			if (!array_key_exists($jobNumber, $totals)) {
				$totals[$jobNumber] = 0;
			}
			$totals[$jobNumber] += $entry->hours;

			// add it to the appropriate week for PRPSAL calculations
			if ($entry->date < $startWeekTwo) {
				$totalWeekOne += $entry->hours;
			} else {
				$totalWeekTwo += $entry->hours;
			}
		}

		$prpsal = array(
			40 - $totalWeekOne,
			40 - $totalWeekTwo
		);

		$calculatedHours = $totalHours + $prpsal[0] + $prpsal[1];

		$data = array(
			'userName' => $user->fname . ' ' . $user->lname,
			'startDate' => $startDate,
			'endDate' => $endDate,
			'entries' => $entries,
			'totalHours' => $totalHours,
			'prpsal' => $prpsal,
			'totals' => $totals,
			'calculatedHours' => $calculatedHours,
			'hourlyRate' => number_format($payAmount / 80, 3)
		);

		$this->layout->title = 'Job Costs Report';
		$this->layout->content = View::make('reports.jobCostsReportResult', $data);
	}

	// Display list of job numbers to generate a report for
	// total hours by employee for a specific job
	public function jobHoursReportInput() {
		$jobNumbers = DB::table('agthourtracker_entries')
						->select('job_number')
						->distinct()
						->get();

		$data = array(
			'jobNumbers' => $jobNumbers
		);

		$this->layout->title = 'Job Hours Report';
		$this->layout->content = View::make('reports.jobHoursReportInput', $data);     
	}

	// Display the total hours for each employee for the selected job
	public function jobHoursReportResult() {
		$jobNumber = Input::get('job_number');

		$entries = Entry::where('job_number', '=', $jobNumber)->get();

		// Get the sum of all hours per user for this job number
		foreach ($entries as $entry) {
			$userId = $entry->user_id;

			if (isset($results[$userId])) {
				$results[$userId] += $entry->hours;
			} else {
				$results[$userId] = $entry->hours;
			}
		}

		// Format the results into a nicer array with user's name
		$totalHours = 0;
		foreach ($results as $userId => $hours) {
			$user = User::find($userId);
			$report[$userId] = array(
				'name' => $user->fname . ' ' . $user->lname,
				'hours' => $hours
			);

			$totalHours += $hours;
		}

		$data = array(
			'jobNumber' => $jobNumber,
			'report' => $report,
			'totalHours' => $totalHours
		);

		$this->layout->title = 'Job Hours Report';
		$this->layout->content = View::make('reports.jobHoursReportResult', $data);
	}

}