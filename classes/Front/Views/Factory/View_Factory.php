<?php

namespace ReviewPlugin\Front\Views\Factory;

use ReviewPlugin\Constants\Items\Design;
use ReviewPlugin\Front\Views\View;
use ReviewPlugin\Front\Views\Impl\Minimal;

/**
 * View_Factory
 */
class View_Factory {

	/**
	 * create
	 *
	 * @param Design $design
	 * @return View
	 */
	public static function create( Design $design ): View {
		switch ( $design->getId() ) {
			case Design::MINIMAL:
				return new Minimal();
				break;

			default:
				throw new \InvalidArgumentException;
				break;
		}
	}
}
