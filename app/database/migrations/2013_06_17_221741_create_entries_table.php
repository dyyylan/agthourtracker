<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration {

	public function up()
	{
		Schema::create('agthourtracker_entries', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->date('date');
			$table->decimal('hours');
			$table->string('job_number');
			$table->string('cost_code');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('agthourtracker_entries');
	}

}
