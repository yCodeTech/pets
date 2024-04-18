<?php

namespace Models;

class User extends BaseModel {
	private $firstname;
	private $lastname;
	private $email;
	private $password;

	function __construct($firstname, $lastname, $email, $password) {
		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->email = $email;
		$this->password = password_hash($password, PASSWORD_DEFAULT);

		parent::__construct();
	}

	public function register() {

		$inserted = parent::insert("user", [
			"id" => null,
			"firstname" => $this->firstname,
			"lastname" => $this->lastname
		]);

		if ($inserted) {
			return parent::insert("user_login", [
				"user_id"=> parent::get_last_id(),
				"email" => $this->email,
				"password"=> $this->password
			]);
		}
	}
}
