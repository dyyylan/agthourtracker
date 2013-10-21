<?php

class EntriesController extends BaseController {

	protected $layout = 'layouts.innerPage';

	// Display form for a new time entry
	public function newEntry() {
		$jobNumbers = Project::where('project_number', 'not like', '%eqp%')
			->orderBy('project_number', 'DESC')
			->get();
		$costCodes = CostCode::groupBy('cost_code')->get();

		// Add additional job numbers and cost codes
		$additionalJobNumbers = AdditionalProject::all();
		$additionalCostCodes = AdditionalCostCode::all();
		$jobNumbers = $jobNumbers->merge($additionalJobNumbers);

		$data = array(
			'jobNumbers' => $jobNumbers,
			'costCodes' => $costCodes
		);

		$this->layout->title = 'New Entry';
		$this->layout->content = View::make('entries.newEntry', $data);
	}

	// Create an entry record in the database
	public function createEntry() {
		$user = Auth::user();

		// Get the source path
		if (Input::get('redirect_to') == 'calendar') {
			$redirect = '/entries/calendar';
		} else {
			$redirect = '/entries/new';
		}

		// Validate the input
		$input = array(
			'date' => Input::get('date'),
			'job_number' => Input::get('job_number'),
			'cost_code' => Input::get('cost_code'),
			'hours' => Input::get('hours') + (Input::get('minutes') / 60)
		);

		$rules = array(
			'date' => array('required', 'date'),
			'job_number' => array('required'),
			'hours' => array('required', 'numeric', 'min:0.25', 'max:24')
		);

		// A cost code is required for 'EST' type jobs
		if (preg_match('/(EST)/', $input['job_number'])) {
			$rules['cost_code'] = array('required');
		}

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			Session::flash('error', 'You are missing a required field or it is formatted incorrectly.');
			return Redirect::to($redirect)->withErrors($validator);
		}

		// Create the record to be saved to db
		$entry = new Entry;
		$entry->user_id = $user->id;
		$entry->date = $input['date'];
		$entry->job_number = $input['job_number'];
		$entry->cost_code = $input['cost_code'];
		$entry->hours = $input['hours'];

		if ($entry->save()) {
			Session::flash('success', 'Time entry successfully added.');
			return Redirect::to($redirect);
		}

		Session::flash('error', 'Time entry could not be saved.');
		return Redirect::to($redirect);
	}

	// Display list of current user's entries
	public function listEntries() {
		$entries = Entry::where('user_id', '=', Auth::user()->id)
						->orderBy('date', 'desc')
						->get();

		// calculate total hours this week
		$hoursThisWeek = 0;
		$thisWeekStartDate = date('Y-m-d', strtotime('today ' . -(date('N') - 1) . ' days'));
		$thisWeekEndDate = date('Y-m-d', strtotime('this sunday'));

		foreach ($entries as $entry) {
			if ($entry->date >= $thisWeekStartDate && $entry->date <= $thisWeekEndDate) {
				$hoursThisWeek += $entry->hours;
			} else {
				break;
			}
		}

		$data = array(
			'entries' => $entries,
			'hoursThisWeek' => $hoursThisWeek
		);

		$this->layout->content = View::make('entries.listEntries')->with($data);
	}

	// Display details for a specific entry
	// This will be converted for the API
	public function showEntry($id) {
		$entry = Entry::find($id);
		echo $entry;
	}

	public function calendar() {
		$user = Auth::user();

		$startDate = Entry::startDateForReport();
		$firstDayOfCalendar = date('Y-m-d', strtotime("-1 week", strtotime($startDate)));

		for ($i = 0; $i < 14; $i++) {
			$calendar[] = array(
				'date' => date('Y-m-d', strtotime("+$i days", strtotime($firstDayOfCalendar)))
			);
		}

		// Add user's entries to the calendar
		foreach ($calendar as $index => $day) {
			$calendar[$index]['entries'] = $user->entries()->where('date', '=', $day['date'])->get();
		}

		// Get the job numbers and cost codes
		$jobNumbers = Project::where('project_number', 'NOT LIKE', '%eqp%')->orderBy('project_number', 'DESC')->get();

		// Add additional job numbers and cost codes
		$additionalJobNumbers = AdditionalProject::all();
		$additionalCostCodes = AdditionalCostCode::all();
		$jobNumbers = $jobNumbers->merge($additionalJobNumbers);

		$data = array(
			'calendar' => $calendar,
			'jobNumbers' => $jobNumbers
		);		

		$this->layout->title = 'My Calendar';
		$this->layout->content = View::make('entries.calendar', $data);
	}

	public function sendReminderEmail() {
		$this->layout = null;

		if (date('w') !== 5) {
			Session::flash('error', 'This script may only be run on Fridays.');
			return Redirect::to('/');
		}

		$users = User::where('is_active', '=', 1)
					->where('receive_emails', '=', 1)
					->where('last_email_sent', '!=', date('Y-m-d'))
					->get();

		// Get the number of entries for each user this week
		$startDate = Entry::startDateForReport();
		$endDate = date('Y-m-d', strtotime('+6 days', strtotime($startDate)));

		foreach ($users as $user) {
			$numEntries = $user->entries()
							->where('date', '>=', $startDate)
							->where('date', '<=', $endDate)
							->count();

			$data = array(
				'user' => $user
			);

			if ($numEntries === 0) {
				$callback = function($message) use ($data) {
					$message->to($data['user']->email);
					$message->subject('Reminder: Submit hours this week [AGT Hour Tracker]');
					$message->bcc('dylanf@advancedroofing.com', 'Dylan Foster');
				};

				if (Mail::send('emails.reminder', $data, $callback)) {
					echo '<p>Mail sent successfully.</p>';
					$user->last_email_sent = date('Y-m-d');
					$user->save();
				} else {
					echo '<p>Mail fail</p>';
				}
			}
		}
	}

	public function deleteEntry() {
		$id = Input::get('id');
		
		$entry = Entry::find($id);

		// Entry could not be found
		if (!$entry) {
			Session::flash('error', 'Could not find an entry with that id.');
			return Redirect::to('/reports/entries');
		}

		// Delete the entry
		$entry->delete();
		Session::flash('success', 'Entry successfully deleted.');

		return Redirect::to('/reports/entries');
	}

}