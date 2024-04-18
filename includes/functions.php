<?php
/**
 * Find and require Composer's autoload.php file.
 */
function composer_autoload() {
	// Get the path of the composer autoload. Dirname retrieves the parent of this file's directory.
	// So __DIR__ gets the includes directory, and dirname retrieves the parent of that.
	// ie. The project home directory.
	$composerAutoload = realpath(dirname(__DIR__, 1).'/vendor/autoload.php');
	if (!file_exists($composerAutoload)) {
		die('Error locating autoloader. Please run <code>composer install</code>.');
	}
	require $composerAutoload;
}

/**
 * Set PHP error reporting
 *
 * @param int $value The value of error reporting. `1` === on, `0` === off
 */
function set_php_error_reporting($value) {
	ini_set('display_errors', $value);
	ini_set('display_startup_errors', $value);
	error_reporting(E_ALL);
}

/**
 * Autoload Controllers and Models via their directory and namespacing.
 */
function autoload_classes() {
	// Because the default function of spl_autoload make the class names lowercase,
	// which works on Windows because it's filesystem is case-insensitive, so a lowercase classname
	// like basecontroller, the function would find the definition in BaseController.php,
	// basecontroller.php, BASEcontroller.php, etc.
	// However, this doesn't work on live servers using case-sensitive systems like Linux.
	// So they would literally be looking for a lowercased file name, and if not found
	// everything breaks.
	//
	// To get around this, we need to name the class files to lowercase with an underscore (the
	// latter for readability), then replace the default function...

	spl_autoload_register(function ($class_name) {
		// The following processes the class names that PHP has found, and converts them to
		// the format for the filenames, so the files can be loaded.

		// Find all uppercase character except the first, and add an underscore before it.
		$class_name = preg_replace('/\B([A-Z])/', '_$1', $class_name);
		// Replace all backslashes (\) with a forwardslash (/)
		$class_name = preg_replace('/\\\/', '/', $class_name);
		// Convert to all lowercase.
		$class_name = strtolower($class_name). ".php";
	
		require_once($class_name);
	});
}

/**
 * ob_start() atop this file stops any HTML/output reaching the page
 * and stores the output internally.
 * This is then used to be able to change the title of the page
 * before sending everything to the page.
 *
 * Code from a previous assignment accessible at https://github.com/yCodeTech/Hotels4U
 * which was based on an answer from StackOverflow: https://stackoverflow.com/a/32337830/2358222
 *
 * @param string $page_title The page title
 */
function page_buffer($page_title = null) {
	// Get the contents of the internal buffer and store it as a variable to be.
	$buffer = ob_get_contents();
	// Erase and disable the internal output buffer.
	ob_end_clean();

	$buffer = set_doc_title($page_title, $buffer);

	// Return the buffer output to the function.
	return $buffer;
}

/**
 * Set the page title.
 *
 * @param string $page_title The page title
 * @param string $buffer The buffered/stored page HTML
 * @return string A modified buffered/stored page HTML with the added page title
 */
function set_doc_title($page_title, $buffer) {
	// If page title is set, get the title and add the site/company name on to it,
	// otherwise just set the title as the site/company name.
	$page_title = (!empty($page_title)) ? $page_title . " | " . SITE_NAME : SITE_NAME;
	// In the buffer, find and replace the <title> tag with the new page title.
	return str_replace("<title></title>", "<title>{$page_title}</title>", $buffer);
}

/**
 * Include the specified view.
 *
 * @param string $view_name The name of the view to include.
 * @param mixed $data The data from the database.
 */
function include_view($view_name, $data = null) {
	if ($data) {
		extract($data);
	}
	include VIEWS_DIR.$view_name . ".php";
}
function include_icon($icon_name) {
	include ICONS_DIR.$icon_name . ".php";
}

/**
 * Check to see if a user is logged in
 */
function is_logged_in() {
	if (isset($_SESSION["user"])) {
		return true;
	}
	return false;
}

function get_server_uri() {
	return $_SERVER['REQUEST_URI'];
}

function back() {
	return $_SERVER['HTTP_REFERER'];
}

function is_allowed_fab() {
	$server_uri = get_server_uri();

	$not_allowed_pages = [
		"/settings",
		"/add_pet",
		"/book_vets"
	];

	if (in_array($server_uri, $not_allowed_pages)) {
		return false;
	}
	return true;
}

function is_protected_page() {
	$server_uri = get_server_uri();

	if (in_array($server_uri, PROTECTED_PAGES)) {
		return true;
	}
	return false;
}

function active_page($link_name) {
	$server_uri = get_server_uri();
	
	if ($server_uri === "/$link_name") {
		return " active";
	}
	return "";
}

function display_toggle_input($name) {
	$id = str_replace([" ", "-"], "_", strtolower($name));

	return "<div class='toggle-container d-flex align-items-center'>
				<input type='checkbox' id='$id' name='$id'>
				<div class='toggle-bg'>
					<label for='$id' class='toggle-btn'></label>
				</div>
				<div class='input-title'>$name</div>
			</div>";
}
