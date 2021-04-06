<?php

namespace ReviewPlugin\Front\Views\Impl;

use ReviewPlugin\Constants\Fields\Post_Meta;
use ReviewPlugin\Front\Views\View;

/**
 * Minimalist
 */
final class Minimalist implements View {

	/**
	 * @var string
	 */
	const DESIGN_CLASS = 'review-plugin-minimalist';

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
<div class="<?php echo self::DESIGN_CLASS; ?>">
	<div class="<?php echo self::DESIGN_CLASS; ?>__block" style="background-color: <?php echo $data[Post_Meta::COLOR]; ?>">
		<div class="<?php echo self::DESIGN_CLASS; ?>__block__post-title">
			<?php if ( !$data[Post_Meta::USE_POST_TITLE] ): ?>
				<?php echo $data[Post_Meta::POST_TITLE]; ?>
			<?php else: ?>
				<?php echo the_title(); ?>
			<?php endif; ?>
		</div>
	</div>

	<div class="<?php echo self::DESIGN_CLASS; ?>__block">
		<div class="<?php echo self::DESIGN_CLASS; ?>__block__conclusion-title">
			<?php echo $data[Post_Meta::CONCLUSION_TITLE]; ?>
		</div>
		<div class="<?php echo self::DESIGN_CLASS; ?>__block__conclusion-contents">
			<?php echo $data[Post_Meta::CONCLUSION_CONTENTS]; ?>
		</div>
	</div>

	<div class="<?php echo self::DESIGN_CLASS; ?>__block">
		<h3>Rating</h3>
		<?php foreach ( $data[Post_Meta::CRITERIAS] as $key => $value ): ?>
			<div>
				<span><?php echo $value; ?></span>：<span><?php echo $data[Post_Meta::CRITERIA_SCORES][$key]; ?></span>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="<?php echo self::DESIGN_CLASS; ?>__block <?php echo self::DESIGN_CLASS; ?>__block--posi-nega-grid">
		<div class="<?php echo self::DESIGN_CLASS; ?>__block__positive-block">
			<div class="<?php echo self::DESIGN_CLASS; ?>__block__positive-block__title"><?php echo $data[Post_Meta::POSI_TITLE]; ?></div>
			<?php foreach ( $data[Post_Meta::POSI_POINTS] as $key => $value ): ?>
				<div class="<?php echo self::DESIGN_CLASS; ?>__block__positive-block__point">
					<?php echo $value; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="<?php echo self::DESIGN_CLASS; ?>__block__negative-block">
			<div class="<?php echo self::DESIGN_CLASS; ?>__block__negative-block__title"><?php echo $data[Post_Meta::NEGA_TITLE]; ?></div>
			<?php foreach ( $data[Post_Meta::NEGA_POINTS] as $key => $value ): ?>
				<div class="<?php echo self::DESIGN_CLASS; ?>__block__negative-block__point">
					<?php echo $value; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="<?php echo self::DESIGN_CLASS; ?>__block <?php echo self::DESIGN_CLASS; ?>__block--final-score-grid">
		<div class="<?php echo self::DESIGN_CLASS; ?>__block__final-score" style="background-color: <?php echo $data[Post_Meta::COLOR]; ?>">
			<div class="<?php echo self::DESIGN_CLASS; ?>__block__final-score__score"><?php echo $data[Post_Meta::CRITERIA_FINAL_SCORE]; ?></div>
			<div class="<?php echo self::DESIGN_CLASS; ?>__block__final-score__title"><?php echo $data[Post_Meta::SCORE_SUBTITLE]; ?></div>
		</div>
	</div>
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

