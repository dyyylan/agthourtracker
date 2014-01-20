<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	protected $table = 'agthourtracker_users';

	protected $hidden = array('password');

	public function getFullName() {
		return $this->fname . ' ' . $this->lname;
	}

	public function entries() { return $this->hasMany('Entry'); }

	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	public function getAuthPassword()
	{
		return $this->password;
	}

	public function getReminderEmail()
	{
		return $this->email;
	}

}