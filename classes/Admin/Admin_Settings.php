<?php

namespace ReviewPlugin\Admin;

use ReviewPlugin\Admin\Views\View_Default_Values;

/**
 * Admin_Settings
 */
class Admin_Settings {

	/**
	 * __construct
	 */
	function __construct() {
		$this->hooks();
	}

	/**
	 * hooks
	 *
	 * @return void
	 */
	public function hooks(): void {
		add_action( 'admin_menu', array( $this, 'menus' ) );
	}

	/**
	 * menus
	 *
	 * @return void
	 */
	public function menus(): void {
		add_options_page( View_Default_Values::TITLE, View_Default_Values::TITLE, 'manage_options', View_Default_Values::SLUG, array( $this, 'controller_default_values' ) );
	}

	/**
	 * controller_default_values
	 *
	 * @return void
	 */
	public function controller_default_values(): void {
		new View_Default_Values();
	}
}

