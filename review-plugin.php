<?php
/*
Plugin Name: Review plugin
Plugin URI:
Description: Review plugin
Author: misclog
Version: 0.1.0
Author URI: https://misc-log.com/
Text Domain: review-plugin
Domain Path: /languages/
*/

/**
 * spl_autoload_register
 */
spl_autoload_register( function ( $class ): void {

	list( $plugin_space ) = explode( '\\', $class );
	if ( $plugin_space !== 'ReviewPlugin' ) {
		return;
	}
	$plugin_dir = basename( __DIR__ );
	$base_dir = plugin_dir_path( __DIR__ ) . '/' . $plugin_dir . '/classes/';
	$relative_class = substr( $class, strlen( $plugin_space ) + 1 );
	$normalize = function( $path ) {
		$path = str_replace( '\\', '/', $path );
		$path = preg_replace( '|(?<=.)/+|', '/', $path );
		if ( ':' === substr( $path, 1, 1 ) ) {
			$path = ucfirst( $path );
		}
		return $path;
	};
	$file = $normalize( $base_dir . $relative_class . '.php' );
	if ( is_readable( $file ) ) {
		require_once $file;
	}
} );

/**
 * initialize_review_plugin
 *
 * @return void
 */
function initialize_review_plugin(): void {
	if ( !defined( 'ABSPATH' ) ) {
		return;
	}
	$plugin_dir = dirname( __FILE__ );
	new \ReviewPlugin\Review_Plugin( $plugin_dir );
}

initialize_review_plugin();
