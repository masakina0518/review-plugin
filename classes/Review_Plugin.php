<?php

namespace ReviewPlugin;

use ReviewPlugin\Admin\Admin_Settings;
use ReviewPlugin\Admin\Custom\Fields\Review_Options;

/**
 * Review_Plugin
 */
class Review_Plugin {

	/**
	 * __construct
	 */
	function __construct() {
		$this->initialize();
	}

	/**
	 * initialize
	 *
	 * @return void
	 */
	public function initialize(): void {
		new Admin_Settings();
		new Review_Options();
	}
}

