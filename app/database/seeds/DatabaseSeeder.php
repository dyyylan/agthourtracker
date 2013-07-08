<?php

class DatabaseSeeder extends Seeder {

	public function run() {
		Eloquent::unguard();

		$this->call('UserTableSeeder');
	}

}

class UserTableSeeder extends Seeder {

	public function run() {
		DB::table('agthourtracker_users')->delete();

		User::create(array(
			'email' => 'dylanf@advancedroofing.com',
			'password' => Hash::make('hello123'),
			'fname' => 'Dylan',
			'lname' => 'Foster',
			'is_admin' => 1
		));
	}

}