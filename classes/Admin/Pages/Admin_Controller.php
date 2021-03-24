<?php

namespace ReviewPlugin\Admin\Pages;

use ReviewPlugin\Path_Manager;
use ReviewPlugin\Admin\Pages\Views\View_Default_Values;
use ReviewPlugin\Admin\Pages\Views\View_Welcome;
use ReviewPlugin\Constants\Commons\Actions;
use ReviewPlugin\Constants\Commons\Capabilities;

/**
 * Admin_Controller
 */
final class Admin_Controller {

	/**
	 * @var string
	 */
	const TITLE = 'Review Plugin';

	/**
	 * @var Path_Manager
	 */
	private $pm;

	/**
	 * __construct
	 *
	 * @param Path_Manager $pm
	 */
	function __construct( Path_Manager $pm ) {
		$this->pm = $pm;
		// TODO:管理ページかどうかの判断をいれたい
		$this->hooks();
	}

	/**
	 * hooks
	 *
	 * @return void
	 */
	public function hooks(): void {
		/** menus */
		add_action(
			Actions::ADMIN_MENU,
			array(
				$this,
				'menus'
			)
		);
		/** sub_menus */
		add_action(
			Actions::ADMIN_MENU,
			array(
				$this,
				'sub_menus'
			)
		);
		/** style */
		add_action(
			Actions::ADMIN_ENQUEUE_SCRIPTS,
			array(
				$this,
				'style'
			)
		);
		/** script */
		add_action(
			Actions::ADMIN_ENQUEUE_SCRIPTS,
			array(
				$this,
				'script'
			)
		);
	}

	/**
	 * menus
	 *
	 * @return void
	 */
	public function menus(): void {
		/** controller_welcome */
		add_menu_page(
			self::TITLE,
			self::TITLE,
			Capabilities::MANAGE_OPTIONS,
			View_Welcome::SLUG,
			array(
				$this,
				'view_welcome'
			),
			'dashicons-admin-generic'
		);
	}

	/**
	 * sub_menus
	 *
	 * @return void
	 */
	public function sub_menus(): void {
		/** controller_welcome */
		add_submenu_page(
			View_Welcome::SLUG,
			View_Welcome::TITLE,
			View_Welcome::TITLE,
			Capabilities::MANAGE_OPTIONS,
			View_Welcome::SLUG,
			array(
				$this,
				'view_welcome'
			),
			1
		);
		/** controller_default_values */
		add_submenu_page(
			View_Welcome::SLUG,
			View_Default_Values::TITLE,
			View_Default_Values::TITLE,
			Capabilities::MANAGE_OPTIONS,
			View_Default_Values::SLUG,
			array(
				$this,
				'view_default_values'
			),
			2
		);
	}

	/**
	 * style
	 *
	 * @return void
	 */
	public function style(): void {
		wp_enqueue_style(
			View_Welcome::SLUG,
			$this->pm->getAdminStylePath(
				View_Welcome::SLUG
			)
		);
		wp_enqueue_style(
			View_Default_Values::SLUG,
			$this->pm->getAdminStylePath(
				View_Default_Values::SLUG
			)
		);
		wp_enqueue_style(
			'wp-color-picker'
		);
	}

	/**
	 * script
	 *
	 * @return void
	 */
	public function script(): void {
		wp_enqueue_script(
			View_Welcome::SLUG,
			$this->pm->getAdminScriptPath(
				View_Welcome::SLUG
			),
			array(
				'jquery',
				'underscore'
			)
		);
		wp_enqueue_script(
			View_Default_Values::SLUG,
			$this->pm->getAdminScriptPath(
				View_Default_Values::SLUG
			),
			array(
				'jquery',
				'underscore'
			)
		);
		wp_enqueue_script(
			'wp-color-picker',
			array(
				'jquery'
			)
		);
	}

	/**
	 * view_welcome
	 *
	 * @return void
	 */
	public function view_welcome(): void {
		new View_Welcome();
	}

	/**
	 * view_default_values
	 *
	 * @return void
	 */
	public function view_default_values(): void {
		new View_Default_Values();
	}
}

