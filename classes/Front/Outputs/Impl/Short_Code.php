<?php

namespace ReviewPlugin\Front\Outputs\Impl;

use ReviewPlugin\Front\Outputs\Output;
use ReviewPlugin\Front\Views\View;

/**
 * Short_Code
 */
final class Short_Code implements Output {

	/**
	 * @var View
	 */
	private $view;

	/**
	 * @var string
	 */
	const NAME = 'review_plugin_shortcode';

	/**
	* @inheritDoc
	*/
	function __construct( View $view ) {
		$this->view = $view;
		$this->hooks();
	}

	/**
	* @inheritDoc
	*/
	public function hooks(): void {
		add_shortcode(
			self::NAME,
			array(
				$this,
				'run'
			)
		);
	}

	/**
	 * run
	 *
	 * @return void
	 */
	public function run( $attrs ) {

		$attrs = shortcode_atts(
			array(
				'count'   => 1,
			),
			$attrs
		);

		$output = 'count:'. $attrs['count'] . $this->view->create();
		return $output;
	}
}

