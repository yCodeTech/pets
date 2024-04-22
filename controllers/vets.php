<?php

namespace Controllers;

use Models\BaseModel;

class Vets {
	private $model;

	public function __construct() {
		$this->model = new BaseModel();
	}

	public function get_data() {
		$surgeries = $this->get_surgeries();
		$vets = $this->get_vet_staff($surgeries);

		return [
			"surgeries" => $surgeries,
			"vets" => $vets
		];
	}
	
	public function get_surgeries() {
		return $this->model->select_all("vet_surgery");
	}
	public function get_vet_staff($surgeries) {
		$data = [];
		foreach ($surgeries as $surgery) {
			$name = str_replace(" ", "_", $surgery["name"]);
			$data[$name] = $this->model->select_all("vet_staff", ["surgery_id" => $surgery["id"]]);
		}
		return $data;
	}
}
