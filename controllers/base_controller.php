<?php

namespace Controllers;

class BaseController {
	private $model;

	function __construct() {
		// $this->model = new Model();
	}
	/**
	 * Load the specified view.
	 *
	 * @param string $view_name The name of the view to include.
	 * @param mixed $data The data from the database.
	 *
	 * @uses global include_view
	 */
	public function load_view($view_name, $data = null) {
		include_view($view_name, $data);
	}
}
