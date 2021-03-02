<?php

namespace ReviewPlugin\Front\Outputs\Impl;

use ReviewPlugin\Front\Outputs\Commons\Output_Methods;
use ReviewPlugin\Front\Outputs\Output;
use ReviewPlugin\Front\Views\View;

/**
 * Bottom
 */
final class Bottom implements Output {

	use Output_Methods;

	/**
	 * @var $view
	 */
	private $view;

	/**
	 * @var $post_id
	 */
	private $post_id;

	/**
	 * @inheritDoc
	 */
	function __construct( View $view, string $post_id ) {
		$this->view = $view;
		$this->post_id = $post_id;
	}


	/**
	* @inheritDoc
	*/
	public function adjust( string $content ): string {
		return $content. 'Bottom!';
	}
}

