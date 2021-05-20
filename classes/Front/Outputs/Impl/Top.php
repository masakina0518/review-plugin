<?php

namespace ReviewPlugin\Front\Outputs\Impl;

use ReviewPlugin\Front\Outputs\Commons\Output_Methods;
use ReviewPlugin\Front\Outputs\Output;
use ReviewPlugin\Front\Views\View;

/**
 * Top
 */
final class Top implements Output {

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
		if ( is_home() || is_front_page() ) {
			return $content;
		}
		$data = $this->get_data( $this->post_id );
		return $this->view->create( $data ).$content;
	}
}

