<?php

namespace ReviewPlugin\Front;

use ReviewPlugin\Constants\Items\Design;
use ReviewPlugin\Constants\Items\Enum;
use ReviewPlugin\Constants\Items\Location;
use ReviewPlugin\Front\Outputs\Factory\Output_Factory;
use ReviewPlugin\Front\Views\Factory\View_Factory;
use ReviewPlugin\Path_Manager;

/**
 * Output_Controller
 */
final class Output_Controller {

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
		$this->initialize();
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	private function initialize() {
		// TODO:利用判定

		// TODO:postmeta空値を取得・設定する
		$view = View_Factory::create(
			Enum::factory(
				Design::class,
				Design::MINIMALIST
			)
		);
		Output_Factory::create(
			Enum::factory(
				Location::class,
				Location::SHORTCODE
			),
			$view
		);
	}
}

