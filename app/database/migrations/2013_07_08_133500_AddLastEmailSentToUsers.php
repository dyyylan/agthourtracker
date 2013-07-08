<?php

use Illuminate\Database\Migrations\Migration;

class AddLastEmailSentToUsers extends Migration {

	public function up()
	{
		Schema::table('agthourtracker_users', function($table) {
			$table->date('last_email_sent')->default('0000-00-00');
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
			$table->dropColumn('last_email_sent');
		});
	}

}