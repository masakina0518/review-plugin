<?php

namespace ReviewPlugin\Front\Views\Factory;

use ReviewPlugin\Constants\Items\Design;
use ReviewPlugin\Front\Views\View;
use ReviewPlugin\Front\Views\Impl\Bold;
use ReviewPlugin\Front\Views\Impl\Clean;
use ReviewPlugin\Front\Views\Impl\Minimalist;
use ReviewPlugin\Front\Views\Impl\Minimalist_B;
use ReviewPlugin\Front\Views\Impl\Modern;
use ReviewPlugin\Front\Views\Impl\Modern_B;

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
			case Design::MINIMALIST:
				return new Minimalist();
				break;

			case Design::BOLD:
				return new Bold();
				break;

			case Design::MODERN:
			return new Modern();
				break;

			case Design::MODERN_B:
				return new Modern_B();
				break;

			case Design::CLEAN:
				return new Clean();
				break;

			case Design::MINIMALIST_B:
				return new Minimalist_B();
				break;

			default:
				throw new \InvalidArgumentException;
				break;
		}
	}
}
