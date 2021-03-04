<?php

namespace ReviewPlugin\Admin\Widgets;

use ReviewPlugin\Admin\Widgets\Impl\Review_lists;
use ReviewPlugin\Path_Manager;

/**
 * Widgets_Controller
 */
final class Widgets_Controller {

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
		// TODO:Widgetページかどうかの判断をいれたい
		$this->hooks();
	}

	/**
	 * hooks
	 *
	 * @return void
	 */
	public function hooks(): void {
		add_action(
			'widgets_init',
			array(
				$this,
				'register'
			)
		);
	}

	/**
	 * register
	 *
	 * @return void
	 */
	public function register(): void {
		register_widget( Review_lists::class );
	}
}
