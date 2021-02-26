<?php

namespace ReviewPlugin;

use ReviewPlugin\Path_Manager;
use ReviewPlugin\Front\Output_Controller;
use ReviewPlugin\Admin\Pages\Admin_Controller;
use ReviewPlugin\Admin\CustomFields\Review_Options;
use ReviewPlugin\Admin\Widgets\Review_lists;

/**
 * Review_Plugin
 */
final class Review_Plugin {

	/**
	 * @var Review_Plugin
	 */
	private static $instance;

	/**
	 * __construct
	 *
	 * @param string $plugin_dir
	 */
	private function __construct( $plugin_dir ) {
		$pm = new Path_Manager( $plugin_dir );
		$this->initialize( $pm );
	}

	/**
	 * getInstance
	 *
	 * @return void
	 */
	public static function getInstance( $plugin_dir ): Review_Plugin {
        if ( !isset( self::$instance ) ) {
            self::$instance = new self( $plugin_dir );
        }
        return self::$instance;
    }

	/**
	 * initialize
	 *
	 * @param Path_Manager $pm
	 * @return void
	 */
	public function initialize( Path_Manager $pm ): void {
		new Admin_Controller( $pm );
		new Review_Options( $pm );
		new Output_Controller( $pm );
		new Review_lists( $pm );
	}

	/**
	 * __clone
	 *
	 * @return void
	 */
	private function __clone() {}
}

