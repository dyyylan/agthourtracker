<?php

use Illuminate\Database\Migrations\Migration;

class AddUserTypes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('agthourtracker_users', function($table) {
			$table->integer('is_admin')->default(0);
			$table->string('location')->default('Canada');
			$table->integer('is_active')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('agthourtracker_users', function($table) {
			$table->dropColumn('is_admin');
			$table->dropColumn('location');
			$table->dropColumn('is_active');
		});
	}

}