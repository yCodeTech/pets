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
		$data["birthday_formatted"] = format_date($data["birthday"]);

		return $data;
	}
	public function delete($type = null) {
		if (isset($_POST["delete_pet"])) {
			$pet_id = $_POST["id"];

			$this->delete_pet_photo("one", ["id" => $pet_id]);

			$deleted = $this->model->delete("pet", $pet_id);

			if ($deleted) {
				$_SESSION["deleted_pet"] = "The pet was deleted.";
				return true;
			}
		}
		elseif (isset($_POST["delete_account"])) {
			$user_id = $_POST["id"];

			$this->delete_pet_photo("all", ["user_id" => $user_id]);

			$deleted = $this->model->delete("user", $user_id);

			if ($deleted) {
				$_SESSION["deleted_account"] = "Your account was deleted.";
				return true;
			}
		}

		// If temp photos
		if ($type === "temp_pet_photo") {
			// Delete all temp photos in the images/uploads/temp directory
			$dir = get_proj_root_dir() . get_uploads_dir() ."temp/";
			array_map('unlink', glob("$dir*"));
		}
	}

	private function delete_pet_photo($select_type, $where) {
		$uploads_dir = get_proj_root_dir() . get_uploads_dir();
		// For the delete a pet.
		if ($select_type === "one") {
			$photo = $this->model->select_one("pet", "photo", $where);

			// Delete the photo
			\Models\File::delete($uploads_dir . $photo["photo"]);
		}
		// For the delete an account.
		elseif ($select_type === "all") {
			$photos = $this->model->select_all("pet", $where);

			foreach ($photos as $photo) {
				// Delete the photo
				\Models\File::delete($uploads_dir . $photo["photo"]);
			}
		}
		
	}

	private function calc_pet_age($birthday) {
		return date("Y") - date('Y', strtotime($birthday));
	}
}
