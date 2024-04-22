<?php

namespace Controllers;

use Models\User;
use Models\Pet;

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
				"email" => "email",
				"password" => "required"
			],
			"add_pet" => [
				"name" => "name",
				"nickname" => "name",
				"species" => "name",
				"breed" => "name",
				"gender" => "set",
				"weight" => "number",
				"colour" => "name",
				"habitat" => "name",
				"birthday" => "required"
			],
			"book_vets" => [
				"surgery" => "required",
				"vet" => "set",
				"pet" => "set",
				"date" => "required",
				"time" => "required"
			]
		];
	}

	public function validate() {
		if (isset($_POST["submit"])) {
			// If form type is edit_pet, then we need to set it's field rules
			// to the same as the add_pet type.
			if ($this->type === "edit_pet") {
				$this->field_rules["edit_pet"] = $this->field_rules["add_pet"];
			}
			
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
				// Add a pet form
				elseif ($this->type === "add_pet") {
					$pet = (new Pet($_SESSION["user"], $this->fields))->add();

					if ($pet) {
						return true;
					}
				}
				// Add a pet form
				elseif ($this->type === "edit_pet") {
					$update = (new Pet($_SESSION["user"], $this->fields))->edit();

					if ($update) {
						return true;
					}
				}
				// Vet booking form
				elseif ($this->type === "book_vets") {
					return [
						"confirm_booking" => true,
						"postback_value" => $this->fields
					];
				}
				// Only for login form
				elseif ($this->type === "login") {
					$user = true;
				}

				// Login and Register forms
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

		if ($this->field_rules[$this->type][$field_name] === "set") {
			if (!isset($this->fields[$field_name])) {
				$this->set_error($field_name, "This is required");
			}
		}

		elseif ($this->rules->is_empty($this->fields[$field_name])) {
			// Nickname isn't required but needs to validate as a name.
			if ($field_name === "nickname") {
				return;
			}
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
			/**
			 * Number
			 */
			if ($this->field_rules[$this->type][$field_name] === "number") {
				if (!$this->rules->is_number($this->fields[$field_name])) {
					$this->set_error($field_name, "Please enter a number");
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
