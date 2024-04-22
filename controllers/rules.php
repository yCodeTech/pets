<?php

namespace Controllers;

use Models\BaseModel;

class Rules {
	private $model;

	function __construct() {
		$this->model = new BaseModel();
	}

	public function is_empty($value) {
		return empty($value);
	}

	/**
	 * Is a name
	 *
	 * @param string $name The field name.
	 * @param string|null $regex_value Extra special characters for the regex to check against.
	 * @return boolean
	 */
	public function is_name($value) {

		// Regex to match an upper and lowercase letters, spaces and other special characters that are passed to it.
		// Provided by https://stackoverflow.com/a/58964725/2358222
		$pattern = "/^(?!.*['-]{2})[a-zA-Z][a-zA-Z\s'-]{1,}$/";
		if (preg_match($pattern, $value)) {
			return true;
		}
		return false;
	}

	/**
	 * Is an email format
	 *
	 * @param string $name The field name.
	 * @return boolean
	 */
	public function is_email($value) {
		if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		return false;
	}
	
	/**
	 * Is a strong password
	 *
	 * Must have:
	 *
	 * - 10 characters minimum
	 * - At least 1 UPPERCASE character
	 * - At least 1 lowercase character
	 * - At least 1 number
	 * - Include a special character
	 */
	public function is_strong_password($value) {

		// Regex to match at least 8 characters
		// Provided by https://stackoverflow.com/a/8141210/2358222

		$pattern = "/^\S*(?=\S{10,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W_])\S*$/";
		if (preg_match($pattern, $value)) {
			return true;
		}
		return false;
	}

	public function is_number($value) {
		return is_numeric($value);
	}

	public function email_exists($email) {
		return $this->model->select_one("user_login", "email", ["email" => $email]);
	}

	public function is_login_valid($email, $password) {
		$data = $this->model->select_one("user_login", "password", ["email" => $email]);

		if (!$data) {
			return false;
		}

		return password_verify($password, $data["password"]);
	}
}
