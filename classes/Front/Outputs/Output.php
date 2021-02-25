<?php

namespace ReviewPlugin\Front\Outputs;

use ReviewPlugin\Front\Views\View;

/**
 * Output
 */
interface Output {

	/**
	 * __construct
	 *
	 * @param View $view
	 */
	function __construct( View $view );

	/**
	 * hooks
	 *
	 * @return void
	 */
	public function hooks(): void;
}
