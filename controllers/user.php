<?php

namespace Controllers;

use Models\BaseModel;

class User extends BaseController {
	private $model;
	private $email;

	function __construct($email) {
		$this->email = $email;
		$this->model = new BaseModel();
	}

	public function get_data() {
		return $this->model->select_user($this->email);
	}
}
