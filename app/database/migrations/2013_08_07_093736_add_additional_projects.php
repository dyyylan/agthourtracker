<?php

use Illuminate\Database\Migrations\Migration;

class AddAdditionalProjects extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agthourtracker_additional_projects', function($table) {
			$table->increments('id');
			$table->string('project_number');
			$table->string('description');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agthourtracker_additional_projects');
	}

}