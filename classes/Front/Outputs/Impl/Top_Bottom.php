<?php

namespace ReviewPlugin\Front\Outputs\Impl;

use ReviewPlugin\Front\Outputs\Output;
use ReviewPlugin\Front\Views\View;

/**
 * Top_Bottom
 */
final class Top_Bottom implements Output {

	/**
	* @inheritDoc
	*/
	function __construct( View $view ) {
		$this->hooks();
	}

	/**
	* @inheritDoc
	*/
	public function hooks(): void {}
}

