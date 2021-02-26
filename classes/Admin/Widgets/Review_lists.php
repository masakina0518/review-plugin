<?php

namespace ReviewPlugin\Admin\Widgets;

use ReviewPlugin\Path_Manager;

/**
 * Review_lists
 */
final class Review_lists {

	/**
	 * @var string
	 */
	const TITLE = 'Review Lists';

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
	}

}
