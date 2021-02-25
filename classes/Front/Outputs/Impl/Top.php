<?php

namespace ReviewPlugin\Front\Outputs\Impl;

use ReviewPlugin\Front\Outputs\Output;
use ReviewPlugin\Front\Views\View;

/**
 * Top
 */
final class Top implements Output {

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

