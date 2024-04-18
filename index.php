<?php

/** Front Controller */

namespace Pet;

use Controllers\BaseController;
use Controllers\FormValidation;
use Controllers\User;

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
	$controller->load_view("logged_in/index", ["viewname" => "view_pets"]);
}

/**
 * Settings
 */
elseif ($server_uri === "/settings") {
	$data = (new User($_SESSION["user"]))->get_data();

	$controller->load_view("logged_in/index", ["viewname" => "settings", "data" => $data]);
}

/**
 * Add Pet
 */
elseif ($server_uri === "/add_pet") {
	$controller->load_view("logged_in/index", ["viewname" => "add_pet"]);
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

else {
	http_response_code(404);
	$controller->load_view("http_errors/404");
}


$controller->load_view("footer");

echo page_buffer();
