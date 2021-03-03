<?php

namespace ReviewPlugin\Front\Outputs\Impl;

use ReviewPlugin\Front\Outputs\Commons\Output_Methods;
use ReviewPlugin\Front\Outputs\Output;
use ReviewPlugin\Front\Views\View;

/**
 * Short_Code
 */
final class Short_Code implements Output {

	use Output_Methods;

	/**
	 * @var View
	 */
	private $view;

	/**
	 * @var $post_id
	 */
	private $post_id;

	/**
	 * @var string
	 */
	const NAME = 'review_plugin_shortcode';

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
		$data = $this->get_data( $this->post_id );
		return $this->view->create( $data );
	}
}

