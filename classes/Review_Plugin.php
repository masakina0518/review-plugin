<?php

namespace ReviewPlugin;

use ReviewPlugin\Path_Manager;
use ReviewPlugin\Admin\Admin_Settings;
use ReviewPlugin\Admin\Custom\Fields\Review_Options;

/**
 * Review_Plugin
 */
final class Review_Plugin {

	/**
	 * __construct
	 *
	 * @param string $plugin_dir
	 */
	function __construct( $plugin_dir ) {
		$pm = Path_Manager::getInstance( $plugin_dir );
		$this->initialize( $pm );
	}

	/**
	 * initialize
	 *
	 * @param Path_Manager $pm
	 * @return void
	 */
	public function initialize( Path_Manager $pm ): void {
		new Admin_Settings( $pm );
		new Review_Options( $pm );
	}
}

