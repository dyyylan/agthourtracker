<?php

use Illuminate\Database\Migrations\Migration;

class AddAdditionalCostcodes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agthourtracker_additional_costcodes', function($table) {
			$table->increments('id');
			$table->integer('project_id')->unsigned();
			$table->addForeign('project_id')->references('id')->on('agthourtracker_additional_projects')->onDelete('cascade');
			$table->string('cost_code');
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
		Schema::drop('agthourtracker_additional_costcodes');
	}

}