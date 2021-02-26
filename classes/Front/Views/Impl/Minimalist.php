<?php

namespace ReviewPlugin\Front\Views\Impl;

use ReviewPlugin\Constants\Fields\Post_Meta;
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
	public function create( array $data ): string {
		ob_start(
			array(
			$this ,
			'filter'
			)
		);
?>

	<div>
		<h2>Rating</h2>
		<?php foreach ( $data[Post_Meta::CRITERIAS] as $key => $value ): ?>
			<div>
				<span><?php echo $value; ?></span>：<span><?php echo $data[Post_Meta::CRITERIA_SCORES][$key]; ?></span>
			</div>
		<?php endforeach; ?>
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

