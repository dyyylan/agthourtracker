@section('content')
<div class="reports-container">
	<div class="well report-description">
		<h3>Weekly Report</h3>	
		<p>
			The primary report, showing number of entries for each week with the ability to drill down and view specific entries and adjustments for each week.
		</p>
		<p><a href="/reports/weekly/overview" class="btn">View &raquo;</a></p>
	</div>

	<div class="well report-description">
		<h3>Job Costs Report</h3>
		<p>
			Enter an employee's salary amount and view a breakdown per project, detailing the total cost for each based on the employee's time entries.
		</p>
		<p><a href="/reports/jobcosts" class="btn">View &raquo;</a></p>
	</div>

	<div class="well report-description">
		<h3>Job Hours Report</h3>
		<p>
			View a summary of each employee's total hours for a selected project. 
		</p>
		<p><a href="/reports/jobhours" class="btn">View &raquo;</a></p>
	</div>
</div>
	

@stop