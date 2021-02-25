<?php

namespace ReviewPlugin;

/**
 * Path_Manager
 */
final class Path_Manager {

	/**
	 * @var Path_Manager
	 */
	private static $instance;

	/**
	 * @var string
	 */
	private $abspath;

	/**
	 * __construct
	 *
	 * @param string $abspath
	 */
	function __construct( string $abspath ) {
		$this->abspath = $abspath . '/';
	}

	/**
	 * getInstance
	 *
	 * @return void
	 */
	public static function getInstance( $plugin_dir ): Path_Manager {
        if ( !isset( self::$instance ) ) {
            self::$instance = new Path_Manager( $plugin_dir );
        }
        return self::$instance;
    }

	/**
	 * getAbsPath
	 *
	 * @return string
	 */
	public function getAbsPath(): string {
		return $this->abspath;
	}

	/**
	 * getAssetsPath
	 *
	 * @return string
	 */
	public function getAssetsPath(): string {
		return $this->abspath . 'assets/';
	}

	/**
	 * getAdminStylePath
	 *
	 * @param string $name
	 * @return string
	 */
	public function getAdminStylePath( string $name ): string {
		return plugin_dir_url( $this->abspath . 'assets/admin/css/*') . $name . '.css';
	}

	/**
	 * getAdminScriptPath
	 *
	 * @param string $name
	 * @return string
	 */
	public function getAdminScriptPath( string $name ): string {
		return plugin_dir_url( $this->abspath . 'assets/admin/js/*') . $name . '.js';
	}

}

