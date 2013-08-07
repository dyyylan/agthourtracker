<?php

/*** TIME ENTRIES ***/

// Entries
Route::get('/', array('uses' => 'EntriesController@calendar', 'before' => 'auth'));
Route::get('/entries', array('uses' => 'EntriesController@listEntries', 'before' => 'auth'));
Route::get('/entries/view/{id}', array('uses' => 'EntriesController@showEntry', 'before' => 'auth'));
Route::get('/entries/new', array('uses' => 'EntriesController@newEntry', 'before' => 'auth'));
Route::post('/entries/new', array('uses' => 'EntriesController@createEntry', 'before' => array('auth', 'csrf')));
Route::get('/entries/calendar', array('uses' => 'EntriesController@calendar', 'before' => 'auth'));

/*** REPORTS ***/

// Weekly reports
Route::get('/reports', array('uses' => 'ReportsController@listReports', 'before' => 'auth'));
Route::get('/reports/weekly', array('uses' => 'ReportsController@weeklyReport', 'before' => 'auth'));
Route::get('/reports/weekly/overview', array('uses' => 'ReportsController@weeklyReportsOverview', 'before' => 'auth'));

// Job costs report
Route::get('/reports/jobcosts', array('uses' => 'ReportsController@jobCostsReportInput', 'before' => 'auth'));
Route::post('/reports/jobcosts', array('uses' => 'ReportsController@jobCostsReportResult', 'before' => array('auth', 'csrf')));

// Job hours report
Route::get('/reports/jobhours', array('uses' => 'ReportsController@jobHoursReportInput', 'before' => 'auth'));
Route::post('/reports/jobhours', array('uses' => 'ReportsController@jobHoursReportResult', 'before' => array('auth', 'csrf')));


/*** USER MANAGEMENT ***/

Route::get('/login', array('uses' => 'UsersController@newSession'));
Route::post('/login', array('uses' => 'UsersController@createSession', 'before' => 'csrf'));
Route::get('/logout', array('uses' => 'UsersController@destroySession', 'before' => 'auth'));
Route::get('/users', array('uses' => 'UsersController@listUsers', 'before' => array('auth', 'admin')));
Route::get('/users/new', array('uses' => 'UsersController@newUser', 'before' => array('auth', 'admin')));
Route::post('/users/new', array('uses' => 'UsersController@createUser', 'before' => array('auth', 'csrf', 'admin')));
Route::get('/users/edit/{id}', array('uses' => 'UsersController@editUser', 'before' => 'auth'));
Route::post('/users/edit/{id}', array('uses' => 'UsersController@updateUser', 'before' => array('auth', 'csrf')));

/*** ADDTL PROJECT MANAGEMENT ***/
Route::get('/projects', array('uses' => 'ProjectsController@listProjects', 'before' => array('auth', 'admin')));
Route::post('/projects/new', array('uses' => 'ProjectsController@createProject', 'before' => array('auth', 'admin', 'csrf')));
Route::post('/projects/delete', array('uses' => 'ProjectsController@deleteProject', 'before' => array('auth', 'admin', 'csrf')));
Route::get('/projects/edit/{id}', array('uses' => 'ProjectsController@editProject', 'before' => array('auth', 'admin')));
Route::post('/projects/costcodes/add', array('uses' => 'ProjectsController@addCostCode', 'before' => array('auth', 'admin', 'csrf')));
Route::post('/projects/costcodes/delete', array('uses' => 'ProjectsController@deleteCostCode', 'before' => array('auth', 'admin', 'csrf')));


/*** UTILITIES ***/
// Send reminder email to users to submit hours
Route::get('/cron/reminder', array('uses' => 'EntriesController@sendReminderEmail'));

/*** REST API ***/
// Get list of cost codes for a selected job number
Route::post('/api/v1/projects/cost_codes', array('uses' => 'ProjectsController@getCostCodesForProject', 'before' => array('auth')));