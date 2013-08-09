<?php

class UsersController extends BaseController {

	protected $layout = 'layouts.innerPage';

	/*** Sessions ***/

	// Displays login screen
	public function newSession() {
		if (Auth::user()) {
			return Redirect::to('/');
		}

		$users = User::where('is_active', '=', 1)->orderBy('fname')->get();

		$data = array(
			'users' => $users
		);

		$this->layout->content = View::make('users.newSession', $data);
	}

	// Logs a user in
	public function createSession() {
		$email = Input::get('email');
		$password = Input::get('password');

		$credentials = array('email' => $email, 'password' => $password);

		if (Auth::attempt($credentials)) {
			return Redirect::intended('/');
		} else {
			Session::flash('error', 'Invalid credentials, please try again.');
			return Redirect::to('login');
		}
	}

	// Logs a user out
	public function destroySession() {
		Auth::logout();
		return Redirect::to('/');
	}

	/*** User Management ***/

	// Displays list of all users
	public function listUsers() {
		$this->layout->title = 'User management';

		$users = User::orderBy('is_active', 'DESC')->orderBy('fname')->get();

		$data = array(
			'users' => $users
		);

		$this->layout->content = View::make('users.listUsers', $data);
	}

	// Display screen for creating a new user
	public function newUser() {
		$this->layout->title = 'New user';

		$this->layout->content = View::make('users.newUser');
	}

	// Create the new user
	public function createUser() {
		$values = array(
			'fname' => Input::get('fname'),
			'lname' => Input::get('lname'),
			'email' => Input::get('email'),
			'password' => Input::get('password')
		);

		$rules = array(
			'fname' => array('required', 'max:40'),
			'lname' => array('required', 'max:40'),
			'email' => array('required', 'email', 'unique:agthourtracker_users,email'),
			'password' => array('required', 'min: 4', 'max:20')
		);

		$validator = Validator::make($values, $rules);

		if ($validator->fails()) {
			Session::flash('error', 'You have errors in one or more of your fields.');
			return Redirect::to('/users/new')->withErrors($validator);
		}

		$user = new User;
		$user->fname = $values['fname'];
		$user->lname = $values['lname'];
		$user->email = $values['email'];
		$user->password = Hash::make($values['password']);
		$user->receive_emails = (Input::get('receive_emails') == 'yes') ? 1 : 0;

		if ($user->save()) {
			$message = 'User sucessfully created.';
			$type = 'success';
		} else {
			$message = 'Error saving user';
			$type = 'error';
		}

		Session::flash($type, $message);
		return Redirect::to('/users');
	}

	// Displays controls for modifying a user's profile
	public function editUser($id) {
		$this->layout->title = 'Edit user';

		// If the user isn't an admin, they can only edit their own profile
		if (!Auth::user()->is_admin) {
			if (Auth::user()->id != $id) {
				Session::flash('error', "You must be an administrator to access that page.");
				return Redirect::to('/entries');
			}
		}

		$user = User::find($id);

		if (!$user) {
			Session::flash('notice', 'Could not find a user with that id.');
			return Redirect::to('/users');
		}

		$data = array(
			'user' => $user
		);

		$this->layout->content = View::make('users.editUser', $data);
	}

	// Process the changes to user's profile
	public function updateUser($id) {
		if (!Auth::user()->is_admin) {
			if (Auth::user()->id != $id) {
				Session::flash('error', "You must be an administrator to access that page.");
				return Redirect::to('/entries');
			}
		}

		$user = User::find($id);
		$newPassword = Input::get('password');
		$isActive = Input::get('is_active');
		$isAdmin = Input::get('is_admin');
		$receiveEmails = Input::get('receive_emails');
		$location = Input::get('location');

		if (!$user) {
			Session::flash('notice', 'Could not find a user with that id');
			return Redirect::to('/users');
		}

		$input = array(
			'password' => Input::get('password')
		);

		$rules = array(
			'password' => array('min:4', 'max:20')
		);

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			Session::flash('error', 'You have errors in one or more of your fields.');
			return Redirect::to('/users/edit/'.$id)->withErrors($validator);
		}

		// Set the values to update
		if (!empty($newPassword)) {
			$user->password = Hash::make(Input::get('password'));
		}

		if (Auth::user()->is_admin) {
			$user->is_active = ($isActive == 'yes') ? 1 : 0;
			$user->is_admin = ($isAdmin == 'yes') ? 1 : 0;
			$user->receive_emails = ($receiveEmails == 'yes') ? 1 : 0;
			$user->location = $location;

			$redirectPath = '/users';
		} else {
			$redirectPath = '/';
		}

		if ($user->save()) {
			$type = 'success';
			$message = 'User successfully updated.';
		} else {
			$type = 'error';
			$message = 'There was a problem updating the user. Changes discarded.';
		}

		Session::flash($type, $message);
		return Redirect::to($redirectPath);
	}

}