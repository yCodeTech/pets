<?php

namespace Controllers;

use Models\User;

class FormValidation {
	private $type;
	private $fields;
	private $errors = [];

	private $rules;

	private $field_rules;
	
	public function __construct($type) {
		$this->type = $type;
		$this->fields = $_POST ?? "";
		$this->rules = new Rules();
		$this->field_rules = [
			"register" => [
				// fieldname => rulename
				"firstname" => "name",
				"lastname" => "name",
				"email" => "email",
				"password"=> "password"
			],
			"login" => [
				"email" => "email"
			]
		];
	}

	public function validate() {
		if (isset($_POST["submit"])) {
			// Test each field against the rules
			foreach ($this->field_rules[$this->type] as $field_name => $rule_name) {
				$this->test_field($field_name);
			}
			
			// Only for login form AND no other errors occurred
			if ($this->type === "login" && !$this->has_errors()) {
				// Test the login details against database
				if (!$this->rules->is_login_valid($this->fields["email"], $this->fields["password"])) {
					$this->set_error("login", "Email or password is incorrect");
				}
			}

			if ($this->has_errors()) {
				return [
					"errors" => $this->errors,
					"postback_value" => $this->fields
				];
			}
			else {
				extract($this->fields);

				// Only for register form
				if ($this->type === "register") {
					$user = (new User($firstname, $lastname, $email, $password))->register();
				}
				// Only for login form
				elseif ($this->type === "login") {
					$user = true;
				}

				if (!$user) {
					return false;
				}
				else {
					$_SESSION["user"] = $this->fields["email"];

					return true;
				}
			}
		}
	}

	private function test_field($field_name) {

		// If there is already an error for the field,
		// don't do anything further.
		if (isset($this->errors[$field_name])) {
			return;
		}

		if ($this->rules->is_empty($this->fields[$field_name])) {
			$this->set_error($field_name, "This is required");
		}
		else {
			/**
			 * Name
			 */
			if ($this->field_rules[$this->type][$field_name] === "name") {
				if (!$this->rules->is_name($this->fields[$field_name])) {
					$this->set_error($field_name, "Please enter only letters, spaces, apostrophes ('), hyphens (-) and more than 1 character");
				}
			}

			/**
			 * Email
			 */
			if ($this->field_rules[$this->type][$field_name] === "email") {
				// Is empty
				if (!$this->rules->is_email($this->fields[$field_name])) {
					$this->set_error($field_name, "Please enter a valid email address, in the form of <strong>name@ provider.extension</strong>");
				}

				// Only for register form
				if ($this->type === "register") {
					// Email already exists
					if ($this->rules->email_exists($this->fields[$field_name])) {
						$this->set_error($field_name, "This email is already registered. Please either login, or enter another email address.");
					}
				}
			}
			/**
			 * Password
			 */
			if ($this->field_rules[$this->type][$field_name] === "password") {
				if (!$this->rules->is_strong_password($this->fields[$field_name])) {
					$this->set_error($field_name, "Please enter a stronger password");
				}
			}
		}
	}

	private function set_error($err_name, $err_msg) {
		$this->errors[$err_name] = "<div class='alert alert-danger error mt-3' role='alert'>". $err_msg."</div>";
	}

	private function has_errors() {
		if (count($this->errors) > 0) {
			return true;
		}
		return false;
	}
}
