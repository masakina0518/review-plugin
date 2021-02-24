<?php

namespace ReviewPlugin\Admin\Custom\Fields;

use ReviewPlugin\Constants\Fields\Post_Meta;
use ReviewPlugin\Constants\Items\Design;
use ReviewPlugin\Constants\Items\Effect;
use ReviewPlugin\Constants\Items\Format;
use ReviewPlugin\Constants\Items\On_Off;
use ReviewPlugin\Constants\Items\Review_Type;
use ReviewPlugin\Constants\Items\Location;
use ReviewPlugin\Constants\Items\Skin;

/**
 * Review_Options
 */
class Review_Options {

	private $id = 'review_options';

	private $title = 'Review Options';

	/**
	 * @var array
	 */
	private $default = [
		Post_Meta::ENABLE_REVIEW => On_Off::OFF,
		Post_Meta::USE_POST_TITLE => On_Off::OFF,
		Post_Meta::REVIEW_TYPE => Review_Type::EDITOR_REVIEW_VISITOR_RATINGS,
		Post_Meta::LOCATION => Location::BOTTOM,
		Post_Meta::FORMAT => Format::PERCENT,
		Post_Meta::SCORE_SUBTITLE => '',
		Post_Meta::CONCLUSION_TITLE => '',
		Post_Meta::CONCLUSION_CONTENTS => '',
		Post_Meta::CRITERIAS => [],
		Post_Meta::CRITERIA_SCORES => [],
		Post_Meta::CRITERIA_FINAL_SCORE => '0',
		Post_Meta::POSI_TITLE => '',
		Post_Meta::POSI_POINTS => [ 'test1', 'test2' ],
		Post_Meta::NEGA_TITLE => '',
		Post_Meta::NEGA_POINTS => [ 'test3', 'test4' ],
		Post_Meta::DESIGN => Design::BOLD,
		Post_Meta::EFFECT => Effect::NONE,
		Post_Meta::SKIN => Skin::LIGHT,
		Post_Meta::COLOR => '',
		Post_Meta::AFFILI_BLOCK_TITLE => '',
		Post_Meta::AFFILI_TITLE => [ 'Amazon' ],
		Post_Meta::AFFILI_URL => [ 'https://www.amazon.co.jp' ],
	];

	/**
	 * __construct
	 */
	function __construct() {
		$this->hooks();
	}

	/**
	 * hooks
	 *
	 * @return void
	 */
	public function hooks(): void {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'post' ) );
	}

	/**
	 * add_meta_box
	 *
	 * @return void
	 */
	public function add_meta_box(): void {
		add_meta_box( $this->id, $this->title, array( $this, 'display' ), array( 'post', 'page' ), 'advanced' );
	}

	/**
	 * marge_options_to_default
	 *
	 * @return array
	 */
	private function marge_options_to_default( array $default ): array {
		foreach ( $default as $field => $value ) {
			$options_field = Post_Meta::convert_options( $field );
			$options_val = get_option( $options_field );
			// Give priority to options value
			if( !is_null( $options_val ) && !is_bool( $options_val ) ) {
				$default[$field] = $options_val;
			}
		}
		return $default;
	}

	/**
	 * marge_postmeta_to_default
	 *
	 * @param array $default
	 * @param [type] $post_id
	 * @return array
	 */
	private function marge_postmeta_to_default( array $default, $post_id ): array {
		foreach ( $default as $field => $value ) {
			$postmeta_val = get_post_meta( $post_id , $field, true );
			// Give priority to postmeta value
			if ( !is_null( $postmeta_val ) && !is_bool( $postmeta_val ) && '' !== $postmeta_val ) {
				$default[$field] = $postmeta_val;
			}
		}
		return $default;
	}
	/**
	 * post
	 *
	 * @param [type] $post_id
	 * @return void
	 */
	public function post( $post_id ) {
		$default = $this->default;
		$post_data = stripslashes_deep( $_POST );
		if ( $post_data ) {
			foreach( $default as $field => $value ) {
				$update_val = $value;
				if ( array_key_exists( $field, $post_data ) ) {
					$update_val = $post_data[$field];
				}
				update_post_meta( $post_id, $field, $update_val );
			}
		}
	}
	/**
	 * display
	 *
	 * @return void
	 */
	public function display(): void {
		$postmeta = $this->marge_postmeta_to_default( $this->marge_options_to_default( $this->default ), get_the_ID() );
	?>

		<h2>ENABLE REVIEW</h2>
		<?php foreach ( On_Off::getEnums() as $enum ): ?>
			<label><input name="<?php echo Post_Meta::ENABLE_REVIEW ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $postmeta[Post_Meta::ENABLE_REVIEW] ); ?> /><?php echo $enum->getName() ?></label>
			<br>
		<?php endforeach; ?>

		<hr>

		<div>
			<h2>GENERAL</h2>
			<h4>USE POST TITLE</h4>
			<label><input name="<?php echo Post_Meta::USE_POST_TITLE ?>" type="checkbox" value="<?php echo On_Off::ON ?>" <?php checked( On_Off::ON, $postmeta[Post_Meta::USE_POST_TITLE] ); ?> /><?php echo $enum->getName() ?></label>

			<br>
			<br>

			<h4>Review Type</h4>
			<select name="<?php echo Post_Meta::REVIEW_TYPE ?>" id="<?php echo Post_Meta::REVIEW_TYPE ?>">
				<?php foreach( Review_Type::getEnums() as $enum ): ?>
					<option value="<?php echo $enum->getId(); ?>" <?php selected( $enum->getId(), $postmeta[Post_Meta::REVIEW_TYPE] ); ?> ><?php echo $enum->getName(); ?></option>
				<?php endforeach; ?>
			</select>

			<br>
			<br>

			<h4>Location</h4>
			<?php foreach ( Location::getEnums() as $enum ): ?>
				<label><input name="<?php echo Post_Meta::LOCATION ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $postmeta[Post_Meta::LOCATION] ); ?> /><?php echo $enum->getName() ?></label><br>
			<?php endforeach; ?>

			<br>
			<br>

			<h4>Format</h4>
			<?php foreach ( Format::getEnums() as $enum ): ?>
				<label><input name="<?php echo Post_Meta::FORMAT ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $postmeta[Post_Meta::FORMAT] ); ?> /><?php echo $enum->getName() ?></label><br>
			<?php endforeach; ?>

			<br>
			<br>

			<h4>Score Subtitle</h4>
			<label for="<?php echo Post_Meta::SCORE_SUBTITLE ?>">Score Subtitle</label>
			<input name="<?php echo Post_Meta::SCORE_SUBTITLE ?>" type="text" id="<?php echo Post_Meta::SCORE_SUBTITLE ?>" value="<?php echo $postmeta[Post_Meta::SCORE_SUBTITLE]; ?>" class="regular-text" />

			<h4>Conclusion</h4>
			<label for="<?php echo Post_Meta::CONCLUSION_TITLE ?>">Conclusion Title</label>
			<input name="<?php echo Post_Meta::CONCLUSION_TITLE ?>" type="text" id="<?php echo Post_Meta::CONCLUSION_TITLE ?>" value="<?php echo $postmeta[Post_Meta::CONCLUSION_TITLE]; ?>" class="regular-text" />

			<br>
			<br>

			<label for="<?php echo Post_Meta::CONCLUSION_CONTENTS ?>">Conclusion Contents</label>
			<textarea name="<?php echo Post_Meta::CONCLUSION_CONTENTS ?>" id="<?php echo Post_Meta::CONCLUSION_CONTENTS ?>" class="regular-text"><?php echo $postmeta[Post_Meta::CONCLUSION_CONTENTS]; ?></textarea>

		</div>

		<hr>

		<div>
			<h2>FIELDS</h2>

			<h4>Criterias</h4>
			<br>
			<?php foreach ( $postmeta[Post_Meta::CRITERIAS] as $key => $val ): ?>
				<div>
					<input name="<?php echo Post_Meta::CRITERIAS.'[]'; ?>" type="text" id="<?php echo Post_Meta::CRITERIAS.$key ?>" value="<?php echo $val; ?>" class="regular-text" />
					<input name="<?php echo Post_Meta::CRITERIA_SCORES.'[]'; ?>" type="text" id="<?php echo Post_Meta::CRITERIA_SCORES.$key ?>" value="<?php echo $postmeta[Post_Meta::CRITERIA_SCORES][$key]; ?>" class="regular-text" />
				</div>
				<br><br>
			<?php endforeach; ?>
			<input name="<?php echo Post_Meta::CRITERIA_FINAL_SCORE; ?>" type="text" id="<?php echo Post_Meta::CRITERIA_FINAL_SCORE ?>" value="<?php echo $postmeta[Post_Meta::CRITERIA_FINAL_SCORE]; ?>" class="regular-text" />

			<br>
			<br>

			<h4>Positives</h4>
			<input name="<?php echo Post_Meta::POSI_TITLE ?>" type="text" id="<?php echo Post_Meta::POSI_TITLE ?>" value="<?php echo $postmeta[Post_Meta::POSI_TITLE]; ?>" class="regular-text" />
			<br><br>
			<?php foreach ( $postmeta[Post_Meta::POSI_POINTS] as $key => $val ): ?>
				&nbsp;<input name="<?php echo Post_Meta::POSI_POINTS.'[]'; ?>" type="text" id="<?php echo Post_Meta::POSI_POINTS.$key ?>" value="<?php echo $val; ?>" class="regular-text" />
				<br><br>
			<?php endforeach; ?>

			<br>
			<br>

			<h4>Negatives</h4>
			<input name="<?php echo Post_Meta::NEGA_TITLE ?>" type="text" id="<?php echo Post_Meta::NEGA_TITLE ?>" value="<?php echo $postmeta[Post_Meta::NEGA_TITLE]; ?>" class="regular-text" />
			<br><br>
			<?php foreach ( $postmeta[Post_Meta::NEGA_POINTS] as $key => $val ): ?>
				&nbsp;<input name="<?php echo Post_Meta::NEGA_POINTS.'[]'; ?>" type="text" id="<?php echo Post_Meta::NEGA_POINTS.$key ?>" value="<?php echo $val; ?>" class="regular-text" />
				<br><br>
			<?php endforeach; ?>


		</div>

		<hr>

		<div>
			<h2>DESIGN</h2>

			<h4>Design</h4>
			<?php foreach ( Design::getEnums() as $enum ): ?>
				<label><input name="<?php echo Post_Meta::DESIGN ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $postmeta[Post_Meta::DESIGN] ); ?> /><?php echo $enum->getName() ?></label><br>
			<?php endforeach; ?>

			<br>

			<h4>Effect</h4>
			<?php foreach ( Effect::getEnums() as $enum ): ?>
				<label><input name="<?php echo Post_Meta::EFFECT ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $postmeta[Post_Meta::EFFECT] ); ?> /><?php echo $enum->getName() ?></label><br>
			<?php endforeach; ?>

			<br>

			<h4>Skin</h4>
			<?php foreach ( Skin::getEnums() as $enum ): ?>
				<label><input name="<?php echo Post_Meta::SKIN ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $postmeta[Post_Meta::SKIN] ); ?> /><?php echo $enum->getName() ?></label><br>
			<?php endforeach; ?>

			<br>

			<h4>Color</h4>
			<label for="<?php echo Post_Meta::COLOR ?>">Accent Color</label>
			<input name="<?php echo Post_Meta::COLOR ?>" type="text" id="<?php echo Post_Meta::COLOR ?>" value="<?php echo $postmeta[Post_Meta::COLOR]; ?>" class="regular-text" />

		</div>

		<hr>

		<div>
			<h2>AFFILIATE</h2>

			<h4>Affliate title</h4>

			<input name="<?php echo Post_Meta::AFFILI_BLOCK_TITLE ?>" type="text" id="<?php echo Post_Meta::AFFILI_BLOCK_TITLE ?>" value="<?php echo $postmeta[Post_Meta::AFFILI_BLOCK_TITLE]; ?>" class="regular-text" />
			<br><br>
			<?php foreach ( $postmeta[Post_Meta::AFFILI_TITLE] as $key => $val ): ?>
				<div>
					<label for="<?php echo Post_Meta::AFFILI_TITLE.$key ?>">TITLE</label>
					<input name="<?php echo Post_Meta::AFFILI_TITLE.'[]'; ?>" type="text" id="<?php echo Post_Meta::AFFILI_TITLE.$key ?>" value="<?php echo $val; ?>" class="regular-text" />

					<label for="<?php echo Post_Meta::AFFILI_URL.$key ?>">URL</label>
					<input name="<?php echo Post_Meta::AFFILI_URL.'[]'; ?>" type="text" id="<?php echo Post_Meta::AFFILI_URL.$key ?>" value="<?php echo $postmeta[Post_Meta::AFFILI_URL][$key]; ?>" class="regular-text" />
				</div>
				<br><br>
			<?php endforeach; ?>

		</div>

		<hr>

		<div>
			<h2>SCHEMA TYPE</h2>

		</div>

	<?php
	}
}
