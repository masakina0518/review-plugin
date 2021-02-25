<?php

namespace ReviewPlugin\Front\Views\Impl;

use ReviewPlugin\Front\Views\View;

/**
 * Minimalist
 */
final class Minimalist implements View {

	/**
	 * @inheritDoc
	 */
	function __construct() {}

	/**
	 * @inheritDoc
	 */
	public function create(): string {
		ob_start(
			array(
			$this ,
			'filter'
			)
		);
?>

		<div>
			<p>It's like comparing apples to oranges.</p>
		</div>

<?php
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/**
	 * filter
	 *
	 * @param string $buffer
	 * @return string
	 */
	function filter( string $buffer ): string {
	  // apples を全て oranges に置換する
	  return ( str_replace( "apples", "oranges", $buffer ) );
	}
}

