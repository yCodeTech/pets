<?php

namespace Models;

class Pet extends BaseModel {
	private $id;
	private $user;
	private $name;
	private $nickname;
	private $species;
	private $breed;
	private $gender;
	private $weight;
	private $colour;
	private $habitat;
	private $birthday;
	private $overweight;
	private $house_trained;
	private $neutered;
	private $had_babies;
	private $wet_food;
	private $dry_food;
	private $treats;
	private $special_requirements;
	private $photo;

	function __construct($user, $data, $photo) {
		extract($data);
		if (isset($id)) {
			$this->id = $id;
		}
		$this->user = $user;
		$this->name = $name;
		$this->nickname = $nickname;
		$this->species = $species;
		$this->breed = $breed;
		$this->gender = $gender;
		$this->weight = $weight;
		$this->colour = $colour;
		$this->habitat = $habitat;
		$this->birthday = $birthday;
		$this->overweight = $overweight ?? "no";
		$this->house_trained = $house_trained ?? "no";
		$this->neutered = $neutered ?? "no";
		$this->had_babies = $had_babies ?? "no";
		$this->wet_food = $wet_food ?: "None";
		$this->dry_food = $dry_food ?: "None";
		$this->treats = $treats ?: "None";
		$this->special_requirements = $special_requirements ?: "None";
		$this->photo = $photo ?? "" ?: "";
		
		parent::__construct();
	}

	public function add() {
		$data = parent::select_one("user_login", "user_id", ["email" => $this->user]);

		return parent::insert("pet", [
			"id" => null,
			"user_id" => $data["user_id"],
			"name" => $this->name,
			"nickname" => $this->nickname,
			"species" => $this->species,
			"breed" => $this->breed,
			"gender" => $this->gender,
			"weight" => $this->weight,
			"colour" => $this->colour,
			"habitat" => $this->habitat,
			"birthday" => $this->birthday,
			"overweight" => $this->overweight,
			"house_trained" => $this->house_trained,
			"neutered" => $this->neutered,
			"had_babies" => $this->had_babies,
			"wet_food" => $this->wet_food,
			"dry_food" => $this->dry_food,
			"treats" => $this->treats,
			"special_requirements" => $this->special_requirements,
			"photo" => $this->photo
		]);
	}
	
	public function edit() {
		$data = parent::select_one("user_login", "user_id", ["email" => $this->user]);

		// Delete the old photo.
		$old_photo = parent::select_one("pet", "photo", ["id" => $this->id, "user_id" => $data["user_id"]]);
		File::delete(get_proj_root_dir() . get_uploads_dir() . $old_photo["photo"]);

		return parent::update("pet", [
			"name" => $this->name,
			"nickname" => $this->nickname,
			"species" => $this->species,
			"breed" => $this->breed,
			"gender" => $this->gender,
			"weight" => $this->weight,
			"colour" => $this->colour,
			"habitat" => $this->habitat,
			"birthday" => $this->birthday,
			"overweight" => $this->overweight,
			"house_trained" => $this->house_trained,
			"neutered" => $this->neutered,
			"had_babies" => $this->had_babies,
			"wet_food" => $this->wet_food,
			"dry_food" => $this->dry_food,
			"treats" => $this->treats,
			"special_requirements" => $this->special_requirements,
			"photo" => $this->photo
		], ["id" => $this->id, "user_id" => $data["user_id"]]);
	}
}
