<?php

define("ROOT_DIR", dirname(__DIR__, 1));

define("VIEWS_DIR", ROOT_DIR . "/views/");
define("ICONS_DIR", ROOT_DIR . "/images/icons/");

define("SITE_NAME", "My Pets");

define("PROTECTED_PAGES", [
	"/settings",
	"/view_pets",
	"/pet_profile",
	"/add_pet",
	"/edit_pet",
	"/book_vets",
	"/delete"
]);
