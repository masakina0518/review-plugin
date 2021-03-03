<?php

namespace ReviewPlugin;

/**
 * Path_Manager
 */
final class Path_Manager {

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
		return $this->getAbsPath() . 'assets/';
	}

	/**
	 * getAdminStylePath
	 *
	 * @param string $name
	 * @return string
	 */
	public function getAdminStylePath( string $name ): string {
		return plugin_dir_url( $this->getAssetsPath() . 'admin/css/*') . $name . '.css';
	}

	/**
	 * getAdminScriptPath
	 *
	 * @param string $name
	 * @return string
	 */
	public function getAdminScriptPath( string $name ): string {
		return plugin_dir_url( $this->getAssetsPath() . 'admin/js/*') . $name . '.js';
	}

	/**
	 * getFrontStylePath
	 *
	 * @param string $name
	 * @return string
	 */
	public function getFrontStylePath( string $name ): string {
		return plugin_dir_url( $this->getAssetsPath() . 'front/css/*') . $name . '.css';
	}

}

