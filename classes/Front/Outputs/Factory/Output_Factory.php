<?php

namespace ReviewPlugin\Front\Outputs\Factory;

use ReviewPlugin\Constants\Items\Location;
use ReviewPlugin\Front\Outputs\Impl\Bottom;
use ReviewPlugin\Front\Outputs\Output;
use ReviewPlugin\Front\Outputs\Impl\Short_Code;
use ReviewPlugin\Front\Outputs\Impl\Top;
use ReviewPlugin\Front\Outputs\Impl\Top_Bottom;
use ReviewPlugin\Front\Views\View;

/**
 * Output_Factory
 */
class Output_Factory {

	/**
	 * create
	 *
	 * @param Location $location
	 * @param View $view
	 * @return Output
	 */
	public static function create( Location $location, View $view, string $post_id ): Output {
		switch ( $location->getId() ) {
			case Location::BOTTOM:
				return new Bottom( $view, $post_id );
				break;

			case Location::TOP:
				return new Top( $view, $post_id );
				break;

			case Location::TOPBOTTOM:
				return new Top_Bottom( $view, $post_id );
				break;

			case Location::SHORTCODE:
				return new Short_Code( $view, $post_id );
				break;

			default:
				throw new \InvalidArgumentException;
				break;
		}
	}
}
