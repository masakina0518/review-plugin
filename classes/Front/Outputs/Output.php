<?php

namespace ReviewPlugin\Front\Outputs;

use ReviewPlugin\Front\Views\View;

/**
 * Output
 */
interface Output {

	/**
	 * __construct
	 *
	 * @param View $view
	 * @param string $post_id
	 */
	function __construct( View $view, string $post_id );

	/**
	 * adjust
	 *
	 * @param $content
	 * @return string
	 */
	public function adjust( string $content ): string;

	/**
	 * get_data
	 *
	 * @param string $post_id
	 * @return array
	 */
	public function get_data( string $post_id ): array;

}
