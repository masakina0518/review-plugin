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

	<?php if ( $data[Post_Meta::USE_POST_TITLE] ): ?>
		<div>
			<h2><?php echo $data[Post_Meta::POST_TITLE]; ?></h2>
		</div>
		<hr>

	<?php else: ?>
		<div>
			<h2><?php echo the_title(); ?></h2>
		</div>
		<hr>

	<?php endif; ?>

	<div>
		<h3>Rating</h3>
		<?php foreach ( $data[Post_Meta::CRITERIAS] as $key => $value ): ?>
			<div>
				<span><?php echo $value; ?></span>：<span><?php echo $data[Post_Meta::CRITERIA_SCORES][$key]; ?></span>
			</div>
		<?php endforeach; ?>
		<div>
			<span><?php echo $data[Post_Meta::CRITERIA_FINAL_SCORE]; ?></span>%<br>
			<span><?php echo $data[Post_Meta::SCORE_SUBTITLE]; ?></span>
		</div>
	</div>

	<hr>

	<div>
		<h3><?php echo $data[Post_Meta::CONCLUSION_TITLE]; ?></h3>
			<div>
				<?php echo $data[Post_Meta::CONCLUSION_CONTENTS]; ?>
			</div>
	</div>

	<hr>

	<div>
		<h3><?php echo $data[Post_Meta::POSI_TITLE]; ?></h3>
		<?php foreach ( $data[Post_Meta::POSI_POINTS] as $key => $value ): ?>
			<div>
				＋<?php echo $value; ?>
			</div>
		<?php endforeach; ?>

	</div>

	<hr>

	<div>
		<h3><?php echo $data[Post_Meta::NEGA_TITLE]; ?></h3>
		<?php foreach ( $data[Post_Meta::NEGA_POINTS] as $key => $value ): ?>
			<div>
				＋<?php echo $value; ?>
			</div>
		<?php endforeach; ?>

	</div>

	<hr>


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

