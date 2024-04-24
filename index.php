<?php

/** Front Controller */

namespace Pet;

use Controllers\BaseController;
use Controllers\FormValidation;
use Controllers\User;
use Controllers\Vets;

session_start();

// Start output buffering
// (prevents all html output from reaching the page and instead stores it internally).
ob_start();

require_once "./includes/constants.php";
require_once "./includes/functions.php";

composer_autoload();
autoload_classes();

// Set the Error reporting
set_php_error_reporting(1);

$controller = new BaseController();

if (is_logged_in()) {
	$user = new User($_SESSION["user"]);
}

$controller->load_view("header");


if (get_server_uri() != "/") {
	$server_uri = get_server_uri();
}
else {
	$server_uri = "/access_portal";
	header("Location: $server_uri");
}

// If the page is protected and the user is not logged in, redirect to the access portal.
if (is_protected_page() && !is_logged_in()) {
	header("Location: /access_portal");
}

if (!str_contains($server_uri, "/add") && !str_contains($server_uri, "/edit") && isset($_SESSION["temp_photo"]) && is_logged_in()) {
	// Delete all temp photos and unset the temp photo session.
	$user->delete("temp_pet_photo");
	unset($_SESSION["temp_photo"]);
}

if ($server_uri === "/access_portal") {
	if (is_logged_in()) {
		header("Location: /view_pets");
	}
	else {
		$controller->load_view("access_portal");
	}
}
/**
 * Login
 */
elseif ($server_uri === "/login") {
	if (is_logged_in()) {
		header("Location: /view_pets");
	}

	$data = (new FormValidation("login"))->validate();


	if (is_array($data) || is_null($data)) {
		$controller->load_view("login", $data);
	}
	else {
		header("Location: /view_pets");
	}
}
/**
 * Logout
 */
elseif ($server_uri === "/logout") {
	// Unset all session keys.
	session_unset();
	
	$_SESSION["loggedout"] = true;

	header("Location: /access_portal");
}
/**
 * Register
 */
elseif ($server_uri === "/register") {
	if (is_logged_in()) {
		header("Location: /view_pets");
	}

	$data = (new FormValidation("register"))->validate();

	if (is_array($data) || is_null($data)) {
		$controller->load_view("register", $data);
	}
	elseif ($data === false) {
		http_response_code(500);
		$controller->load_view("http_errors/500");
	}
	else {
		header("Location: /view_pets");
	}
}

/**
 * View Pets
 */
elseif ($server_uri === "/view_pets") {
	$data = $user->get_pets();
	$controller->load_view("logged_in/index", ["viewname" => "view_pets", "pets" => $data]);
}

/**
 * Pet Profile
 */
elseif (str_contains($server_uri, "/pet_profile")) {
	$data = $user->get_pet($_GET["id"]);
	$controller->load_view("logged_in/index", ["viewname" => "pet_profile", "pet" => $data]);
}

/**
 * Add Pet
 */
elseif ($server_uri === "/add_pet") {
	$data = (new FormValidation("add_pet"))->validate();

	if (is_array($data) || is_null($data)) {
		$controller->load_view("logged_in/index", ["viewname" => "pet_form", "data" => $data]);
	}
	elseif ($data === false) {
		http_response_code(500);
		$controller->load_view("http_errors/500");
	}
	else {
		header("Location: /view_pets");
	}
}

/**
 * Edit Pet
 */
elseif (str_contains($server_uri, "/edit_pet")) {
	$id = $_GET["id"];
	// If the form validation is null, just get the pet info from database
	// (form validation will only be not not when the update btn is clicked).
	$data = (new FormValidation("edit_pet"))->validate() ?? $user->get_pet($id);
	
	if (is_array($data) || is_null($data)) {
		$controller->load_view("logged_in/index", [
			"viewname" => "pet_form",
			"postback_value" => $data,
			"go_back_url" => "/pet_profile?id=$id",
			"pet_id" => $id
		]);
	}
	elseif ($data === false) {
		http_response_code(500);
		$controller->load_view("http_errors/500");
	}
	else {
		header("Location: /pet_profile?id=$id");
	}
}

/**
 * Delete (a pet or an account)
 */
elseif ($server_uri === "/delete") {
	$data = $user->delete();

	if ($data === false) {
		http_response_code(500);
		$controller->load_view("http_errors/500");
	}
	else {
		if ($_SESSION["deleted_account"]) {
		// Unset all session keys.
			unset($_SESSION["user"]);
			header("Location: /access_portal");
		}
		elseif ($_SESSION["deleted_pet"]) {
			header("Location: /view_pets");
		}
	}
}

/**
 * Settings
 */
elseif ($server_uri === "/settings") {
	$data = $user->get_details();

	$controller->load_view("logged_in/index", ["viewname" => "settings", "data" => $data]);
}
/**
 * Book Vets
 */
elseif ($server_uri === "/book_vets") {
	$data = (new FormValidation("book_vets"))->validate() ?? [];

	if (isset($data["confirm_booking"])) {
		foreach ($data["postback_value"]["pet"] as $key => $value) {
			$pet_details[] = $user->get_pet($value);
		}

		$vet_individual = (new Vets())->get_one_vet_and_surgery($data["postback_value"]["vet"]);
	}

	$vets_data = (new Vets())->get_data();
	
	$extra = [
		"pet_details" => $pet_details ?? [],
		"vet_individual" => $vet_individual ?? []
	];

	$data = array_merge($data, $vets_data, ["pets" => $user->get_pets()], ["extra" => $extra]);

	$controller->load_view("logged_in/index", ["viewname" => "book_vets", "data" => $data]);
}


else {
	http_response_code(404);
	$controller->load_view("http_errors/404");
}


$controller->load_view("footer");

echo page_buffer();
