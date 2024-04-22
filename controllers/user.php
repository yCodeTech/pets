<?php

namespace Controllers;

use Models\BaseModel;

class User extends BaseController {
	private $model;
	private $email;
	private $user_id;

	function __construct($email) {
		$this->email = $email;
		$this->model = new BaseModel();
		$this->user_id = $this->get_user_id();
	}

	public function get_details() {
		return $this->model->select_user($this->email);
	}
	public function get_user_id() {
		$data = $this->model->select_one("user_login", "user_id", ["email" => $this->email]);
		return $data["user_id"];
	}

	public function get_pets() {
		$data = $this->model->select_all("pet", ["user_id" => $this->user_id]);

		foreach ($data as $pet => $val) {
			$data[$pet]["age"] = $this->calc_pet_age($val["birthday"]);
		}
		return $data;
	}
	public function get_pet($id) {

		$data = $this->model->select_one("pet", "*", ["id" => $id]);
		$data["age"] = $this->calc_pet_age($data["birthday"]);
		$data["birthday_formatted"] = $this->format_date($data["birthday"]);

		return $data;
	}
	public function delete() {
		if (isset($_POST["delete_pet"])) {
			$deleted = $this->model->delete("pet", $_POST["id"]);

			if ($deleted) {
				$_SESSION["deleted_pet"] = "The pet was deleted.";
				return true;
			}
		}
		elseif (isset($_POST["delete_account"])) {
			$deleted = $this->model->delete("user", $_POST["id"]);

			if ($deleted) {
				$_SESSION["deleted_account"] = "Your account was deleted.";
				return true;
			}
		}
	}

	private function calc_pet_age($birthday) {
		return date("Y") - date('Y', strtotime($birthday));
	}
	public function format_date($date, $format = "j/n/Y") {
		return date($format, strtotime($date));
	}
}
