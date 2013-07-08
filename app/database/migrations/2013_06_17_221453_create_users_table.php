<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('agthourtracker_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('password');
			$table->string('fname');
			$table->string('lname');
			$table->integer('receive_emails')->default(1);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('agthourtracker_users');
	}

}
