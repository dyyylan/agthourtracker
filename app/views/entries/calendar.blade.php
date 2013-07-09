@section('content')

<h1>My Time Entries</h1>
<p>Displaying time entries for this week and last week. To create a new time entry, click on a day on the calendar and enter the appropriate data.</p>
<p>To add an entry for a previous day, you may use the <a href="/entries/new">single time entry</a> link.</p>

<div id="calendar-header">
	<?php $dayLabels = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'); ?>
	@for ($i = 0; $i < 7; $i++)
		<div class="calendar-header-day">
			<h4>{{ $dayLabels[$i] }}</h4>
		</div>
	@endfor
</div>

<div id="calendar">
@foreach ($calendar as $index => $day)
	<!-- Calendar and modal launcher buttons -->
	<div class="calendar-day{{ (date('Y-m-d') === $day['date']) ? ' today' : '' }}{{ (date('N', strtotime($day['date'])) > 5) ? ' weekend' : '' }}">
		<a href="#modalEntry{{ $day['date'] }}" class="calendar-modal-link" data-toggle="modal">
			<div class="calendar-day-contents">
				<h3>{{ date('j', strtotime($day['date'])) }}</h3>
				@if (count($day['entries']))
					<ul class="calendar-entries">
						@foreach ($day['entries'] as $entry)
							<li>{{ $entry->job_number }} ({{ (float) $entry->hours }})</li>
						@endforeach
					</ul>
				@endif
			</div>
		</a>
	</div>

	<!-- Modal -->
	<div id="modalEntry{{ $day['date'] }}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalEntry{{ $day['date'] }}Label" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="modalEntry{{ $day['date'] }}Label">New time entry: {{ date('F jS, Y', strtotime($day['date'])) }}</h3>
		</div>

		<form method="post" action="/entries/new">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<input type="hidden" name="date" value="{{ $day['date'] }}" />
			<input type="hidden" name="redirect_to" value="calendar" />

			<div class="modal-body">
				<div class="field">
					<label for="hours">Duration:</label>
					<select name="hours" id="hours">
						<option value="0">Hours</option>
						@for ($hours = 0; $hours < 13; $hours++): ?>
							<option value="{{ $hours }}">{{ $hours }} hours</option>
						@endfor
					</select>
					<select name="minutes" id="minutes">
						<option value="0">Minutes</option>
						@for ($minutes = 0; $minutes < 60; $minutes += 15): ?>
							<option value="{{ $minutes }}">{{ $minutes }} minutes</option>
						@endfor
					</select>
				</div>

				<div class="field">
					<label for="job_number">Job number:</label>
					<select name="job_number" id="job_number">
						<option value="">Select...</option>
						@foreach ($jobNumbers as $jobNumber)
							<option value="{{ $jobNumber->jobnumber }}">
								{{ $jobNumber->jobnumber }} :: {{ $jobNumber->projectdescription }}
							</option>
						@endforeach
					</select>
				</div>

				<div class="field">
					<label for="cost_code">Cost code:</label>
					<select name="cost_code" id="cost_code">
						<option value="">Select...</option>
						@foreach ($costCodes as $costCode)
							<option value="{{ $costCode->costcode }} :: {{ $costCode->costcodedesc }}">
								{{ $costCode->costcode }} :: {{ $costCode->costcodedesc }}
							</option>
						@endforeach
					</select>
				</div>

			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
				<input type="submit" value="Add Entry" class="btn btn-primary" />
			</div>
		</form>
		

	</div>
@endforeach

</div>

<div style="clear:both;"></div>

@stop