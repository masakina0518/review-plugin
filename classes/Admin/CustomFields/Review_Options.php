<?php

namespace ReviewPlugin\Admin\CustomFields;

use ReviewPlugin\Path_Manager;
use ReviewPlugin\Constants\Forms\Default_Values;
use ReviewPlugin\Constants\Commons\Actions;
use ReviewPlugin\Constants\Fields\Post_Meta;
use ReviewPlugin\Constants\Items\Design;
use ReviewPlugin\Constants\Items\Effect;
use ReviewPlugin\Constants\Items\Format;
use ReviewPlugin\Constants\Items\On_Off;
use ReviewPlugin\Constants\Items\Review_Type;
use ReviewPlugin\Constants\Items\Location;
use ReviewPlugin\Constants\Items\Skin;
use ReviewPlugin\Constants\Items\Schema_Type;

/**
 * Review_Options
 */
final class Review_Options {

	/**
	 * @var string
	 */
	const ID = 'review_options';

	/**
	 * @var string
	 */
	const TITLE = 'Review Options';

	/**
	 * @var array
	 */
	CONST FORM_DEFAULT_VALUES = Default_Values::REVIEW_OPTIONS;
	/**
	 * __construct
	 *
	 * @param Path_Manager $pm
	 */
	function __construct( Path_Manager $pm ) {
		$this->pm = $pm;
		// TODO:投稿ページかどうかの判断をいれたい
		$this->hooks();
	}

	/**
	 * hooks
	 *
	 * @return void
	 */
	public function hooks(): void {
		/** add_meta_box */
		add_action(
			Actions::ADD_META_BOXES,
			array(
				$this,
				'add_meta_box'
			)
		);
		/** post */
		add_action(
			Actions::SAVE_POST,
			array(
				$this,
				'post'
			)
		);
		/** style */
		add_action(
			Actions::ADMIN_ENQUEUE_SCRIPTS,
			array(
				$this,
				'style'
			)
		);
		/** script */
		add_action(
			Actions::ADMIN_ENQUEUE_SCRIPTS,
			array(
				$this,
				'script'
			)
		);
	}

	/**
	 * add_meta_box
	 *
	 * @return void
	 */
	public function add_meta_box(): void {
		/** display */
		add_meta_box(
			self::ID,
			self::TITLE,
			array(
				$this,
				'display'
			),
			array(
				'post',
				'page'
			),
			'advanced'
		);
	}

	/**
	 * style
	 *
	 * @return void
	 */
	public function style(): void {
		wp_enqueue_style(
			self::ID,
			$this->pm->getAdminStylePath(
				self::ID
			)
		);
	}

	/**
	 * script
	 *
	 * @return void
	 */
	public function script(): void {
		wp_enqueue_script(
			self::ID,
			$this->pm->getAdminScriptPath(
				self::ID
			),
			array(
				'jquery',
				'underscore'
			)
		);
	}

	/**
	 * marge_options_to_default
	 *
	 * @param $default
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
			$form_val = get_post_meta( $post_id , $field, true );
			// Give priority to postmeta value
			if ( !is_null( $form_val ) && !is_bool( $form_val ) && '' !== $form_val ) {
				$default[$field] = $form_val;
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
	public function post( $post_id ): void {
		$default = self::FORM_DEFAULT_VALUES;
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
		$form = $this->marge_postmeta_to_default(
			$this->marge_options_to_default(
				self::FORM_DEFAULT_VALUES
			),
			get_the_ID()
		);
?>

		<h2>ENABLE REVIEW</h2>
		<?php foreach ( On_Off::getEnums() as $enum ): ?>
			<label><input name="<?php echo Post_Meta::ENABLE_REVIEW ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Post_Meta::ENABLE_REVIEW] ); ?> /><?php echo $enum->getName() ?></label>
			<br>
		<?php endforeach; ?>

		<hr>

		<div>
			<h2>GENERAL</h2>
			<h4>USE POST TITLE</h4>
			<label><input name="<?php echo Post_Meta::USE_POST_TITLE ?>" type="checkbox" value="<?php echo On_Off::ON ?>" <?php checked( On_Off::ON, $form[Post_Meta::USE_POST_TITLE] ); ?> /><?php echo $enum->getName() ?></label>
			<input name="<?php echo Post_Meta::POST_TITLE ?>" type="text" id="<?php echo Post_Meta::POST_TITLE ?>" value="<?php echo $form[Post_Meta::POST_TITLE]; ?>" class="regular-text" />

			<br>
			<br>

			<h4>Review Type</h4>
			<select name="<?php echo Post_Meta::REVIEW_TYPE ?>" id="<?php echo Post_Meta::REVIEW_TYPE ?>">
				<?php foreach( Review_Type::getEnums() as $enum ): ?>
					<option value="<?php echo $enum->getId(); ?>" <?php selected( $enum->getId(), $form[Post_Meta::REVIEW_TYPE] ); ?> ><?php echo $enum->getName(); ?></option>
				<?php endforeach; ?>
			</select>

			<br>
			<br>

			<h4>Location</h4>
			<?php foreach ( Location::getEnums() as $enum ): ?>
				<label><input name="<?php echo Post_Meta::LOCATION ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Post_Meta::LOCATION] ); ?> /><?php echo $enum->getName() ?></label><br>
			<?php endforeach; ?>

			<br>
			<br>

			<h4>Format</h4>
			<?php foreach ( Format::getEnums() as $enum ): ?>
				<label><input name="<?php echo Post_Meta::FORMAT ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Post_Meta::FORMAT] ); ?> /><?php echo $enum->getName() ?></label><br>
			<?php endforeach; ?>

			<br>
			<br>

			<h4>Score Subtitle</h4>
			<label for="<?php echo Post_Meta::SCORE_SUBTITLE ?>">Score Subtitle</label>
			<input name="<?php echo Post_Meta::SCORE_SUBTITLE ?>" type="text" id="<?php echo Post_Meta::SCORE_SUBTITLE ?>" value="<?php echo $form[Post_Meta::SCORE_SUBTITLE]; ?>" class="regular-text" />

			<h4>Conclusion</h4>
			<label for="<?php echo Post_Meta::CONCLUSION_TITLE ?>">Conclusion Title</label>
			<input name="<?php echo Post_Meta::CONCLUSION_TITLE ?>" type="text" id="<?php echo Post_Meta::CONCLUSION_TITLE ?>" value="<?php echo $form[Post_Meta::CONCLUSION_TITLE]; ?>" class="regular-text" />

			<br>
			<br>

			<label for="<?php echo Post_Meta::CONCLUSION_CONTENTS ?>">Conclusion Contents</label>
			<textarea name="<?php echo Post_Meta::CONCLUSION_CONTENTS ?>" id="<?php echo Post_Meta::CONCLUSION_CONTENTS ?>" class="regular-text"><?php echo $form[Post_Meta::CONCLUSION_CONTENTS]; ?></textarea>

		</div>

		<hr>

		<div>
			<h2>FIELDS</h2>

			<h4>Criterias</h4>
			<br>
			<div id="<?php echo Post_Meta::CRITERIAS; ?>">
				<?php foreach ( $form[Post_Meta::CRITERIAS] as $key => $value ): ?>
					<div>
						<input name="<?php echo Post_Meta::CRITERIAS.'[]'; ?>" type="text" id="<?php echo Post_Meta::CRITERIAS.$key ?>" value="<?php echo $value; ?>" class="regular-text" />
						<input name="<?php echo Post_Meta::CRITERIA_SCORES.'[]'; ?>" type="text" id="<?php echo Post_Meta::CRITERIA_SCORES.$key ?>" value="<?php echo $form[Post_Meta::CRITERIA_SCORES][$key]; ?>" class="small-text" />
						<br><br>
					</div>
				<?php endforeach; ?>

				<script type="text/html" id="<?php echo Post_Meta::CRITERIAS; ?>_template">
					<div>
						<input name="<?php echo Post_Meta::CRITERIAS.'[]'; ?>" type="text" value="" class="regular-text" />
						<input name="<?php echo Post_Meta::CRITERIA_SCORES.'[]'; ?>" type="hidden"  value="0" class="regular-text" />
						<br><br>
					</div>
				</script>
			</div>

			Final Score <input name="<?php echo Post_Meta::CRITERIA_FINAL_SCORE; ?>" type="text" id="<?php echo Post_Meta::CRITERIA_FINAL_SCORE ?>" value="<?php echo $form[Post_Meta::CRITERIA_FINAL_SCORE]; ?>" class="small-text" />

			<br>
			<br>

			<h4>Positives</h4>
			<input name="<?php echo Post_Meta::POSI_TITLE ?>" type="text" id="<?php echo Post_Meta::POSI_TITLE ?>" value="<?php echo $form[Post_Meta::POSI_TITLE]; ?>" class="regular-text" />
			<br><br>
			<?php foreach ( $form[Post_Meta::POSI_POINTS] as $key => $value ): ?>
				&nbsp;<input name="<?php echo Post_Meta::POSI_POINTS.'[]'; ?>" type="text" id="<?php echo Post_Meta::POSI_POINTS.$key ?>" value="<?php echo $value; ?>" class="regular-text" />
				<br><br>
			<?php endforeach; ?>

			<br>
			<br>

			<h4>Negatives</h4>
			<input name="<?php echo Post_Meta::NEGA_TITLE ?>" type="text" id="<?php echo Post_Meta::NEGA_TITLE ?>" value="<?php echo $form[Post_Meta::NEGA_TITLE]; ?>" class="regular-text" />
			<br><br>
			<?php foreach ( $form[Post_Meta::NEGA_POINTS] as $key => $value ): ?>
				&nbsp;<input name="<?php echo Post_Meta::NEGA_POINTS.'[]'; ?>" type="text" id="<?php echo Post_Meta::NEGA_POINTS.$key ?>" value="<?php echo $value; ?>" class="regular-text" />
				<br><br>
			<?php endforeach; ?>


		</div>

		<hr>

		<div>
			<h2>DESIGN</h2>

			<h4>Design</h4>
			<?php foreach ( Design::getEnums() as $enum ): ?>
				<label><input name="<?php echo Post_Meta::DESIGN ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Post_Meta::DESIGN] ); ?> /><?php echo $enum->getName() ?></label><br>
			<?php endforeach; ?>

			<br>

			<h4>Effect</h4>
			<?php foreach ( Effect::getEnums() as $enum ): ?>
				<label><input name="<?php echo Post_Meta::EFFECT ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Post_Meta::EFFECT] ); ?> /><?php echo $enum->getName() ?></label><br>
			<?php endforeach; ?>

			<br>

			<h4>Skin</h4>
			<?php foreach ( Skin::getEnums() as $enum ): ?>
				<label><input name="<?php echo Post_Meta::SKIN ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Post_Meta::SKIN] ); ?> /><?php echo $enum->getName() ?></label><br>
			<?php endforeach; ?>

			<br>

			<h4>Color</h4>
			<label for="<?php echo Post_Meta::COLOR ?>">Accent Color</label>
			<input name="<?php echo Post_Meta::COLOR ?>" type="text" id="<?php echo Post_Meta::COLOR ?>" value="<?php echo $form[Post_Meta::COLOR]; ?>" class="regular-text" />

		</div>

		<hr>

		<div>
			<h2>AFFILIATE</h2>

			<h4>Affliate title</h4>

			<input name="<?php echo Post_Meta::AFFILI_BLOCK_TITLE ?>" type="text" id="<?php echo Post_Meta::AFFILI_BLOCK_TITLE ?>" value="<?php echo $form[Post_Meta::AFFILI_BLOCK_TITLE]; ?>" class="regular-text" />
			<br><br>
			<div id="<?php echo Post_Meta::AFFILI_TITLE; ?>">
				<?php foreach ( $form[Post_Meta::AFFILI_TITLE] as $key => $value ): ?>
					<div>
						<label for="<?php echo Post_Meta::AFFILI_TITLE.$key ?>">TITLE</label>
						<input name="<?php echo Post_Meta::AFFILI_TITLE.'[]'; ?>" type="text" id="<?php echo Post_Meta::AFFILI_TITLE.$key ?>" value="<?php echo $value; ?>" class="regular-text" />
						<label for="<?php echo Post_Meta::AFFILI_URL.$key ?>">URL</label>
						<input name="<?php echo Post_Meta::AFFILI_URL.'[]'; ?>" type="text" id="<?php echo Post_Meta::AFFILI_URL.$key ?>" value="<?php echo $form[Post_Meta::AFFILI_URL][$key]; ?>" class="regular-text" />
					</div>
					<br><br>
				<?php endforeach; ?>

				<script type="text/html" id="<?php echo Post_Meta::AFFILI_TITLE; ?>_template">
					<div>
						<label>TITLE</label>
						<input name="<?php echo Post_Meta::AFFILI_TITLE.'[]'; ?>" type="text" value="" class="regular-text" />
						<label>URL</label>
						<input name="<?php echo Post_Meta::AFFILI_URL.'[]'; ?>" type="text" value="" class="regular-text" />
					</div>
					<br><br>
				</script>
			</div>
		</div>

		<hr>

		<div>
			<h2>SCHEMA TYPE</h2>
			<select name="<?php echo Post_Meta::SCHEMA_TYPE ?>" id="<?php echo Post_Meta::SCHEMA_TYPE ?>">
				<?php foreach( Schema_Type::getEnums() as $enum ): ?>
					<option value="<?php echo $enum->getId(); ?>" <?php selected( $enum->getId(), $form[Post_Meta::SCHEMA_TYPE] ); ?> ><?php echo $enum->getName(); ?></option>
				<?php endforeach; ?>
			</select>

			<h4>SCHEMA PROPERTIES</h4>

			<div id="<?php echo Post_Meta::SCHEMA_TYPE; ?>_2">
				<label for="<?php echo Post_Meta::SCHEMA_PROPERTIE_DESCRIPTION ?>">DESCRIPTION</label>
				<input name="<?php echo Post_Meta::SCHEMA_PROPERTIE_DESCRIPTION ?>" type="text" id="<?php echo Post_Meta::SCHEMA_PROPERTIE_DESCRIPTION ?>" value="<?php echo $form[Post_Meta::SCHEMA_PROPERTIE_DESCRIPTION]; ?>" class="regular-text" />

				<br><br>
				<label for="<?php echo Post_Meta::SCHEMA_PROPERTIE_SKU ?>">SKU</label>
				<input name="<?php echo Post_Meta::SCHEMA_PROPERTIE_SKU ?>" type="text" id="<?php echo Post_Meta::SCHEMA_PROPERTIE_SKU ?>" value="<?php echo $form[Post_Meta::SCHEMA_PROPERTIE_SKU]; ?>" class="regular-text" />

				<br><br>
				<label for="<?php echo Post_Meta::SCHEMA_PROPERTIE_MPN ?>">MPN</label>
				<input name="<?php echo Post_Meta::SCHEMA_PROPERTIE_MPN ?>" type="text" id="<?php echo Post_Meta::SCHEMA_PROPERTIE_MPN ?>" value="<?php echo $form[Post_Meta::SCHEMA_PROPERTIE_MPN]; ?>" class="regular-text" />

				<br><br>
				<label for="<?php echo Post_Meta::SCHEMA_PROPERTIE_ISBN ?>">ISBN</label>
				<input name="<?php echo Post_Meta::SCHEMA_PROPERTIE_ISBN ?>" type="text" id="<?php echo Post_Meta::SCHEMA_PROPERTIE_ISBN ?>" value="<?php echo $form[Post_Meta::SCHEMA_PROPERTIE_ISBN]; ?>" class="regular-text" />

				<br><br>
				<label for="<?php echo Post_Meta::SCHEMA_PROPERTIE_BRAND ?>">BRAND</label>
				<input name="<?php echo Post_Meta::SCHEMA_PROPERTIE_BRAND ?>" type="text" id="<?php echo Post_Meta::SCHEMA_PROPERTIE_BRAND ?>" value="<?php echo $form[Post_Meta::SCHEMA_PROPERTIE_BRAND]; ?>" class="regular-text" />

				<br><br>
			</div>

			<div id="<?php echo Post_Meta::SCHEMA_TYPE; ?>_4">
				<label for="<?php echo Post_Meta::SCHEMA_PROPERTIE_DIRECTOR ?>">DIRECTOR</label>
				<input name="<?php echo Post_Meta::SCHEMA_PROPERTIE_DIRECTOR ?>" type="text" id="<?php echo Post_Meta::SCHEMA_PROPERTIE_DIRECTOR ?>" value="<?php echo $form[Post_Meta::SCHEMA_PROPERTIE_DIRECTOR]; ?>" class="regular-text" />

				<br><br>
				<label for="<?php echo Post_Meta::SCHEMA_PROPERTIE_DATE_CREATED ?>">DATE CREATED</label>
				<input name="<?php echo Post_Meta::SCHEMA_PROPERTIE_DATE_CREATED ?>" type="text" id="<?php echo Post_Meta::SCHEMA_PROPERTIE_DATE_CREATED ?>" value="<?php echo $form[Post_Meta::SCHEMA_PROPERTIE_DATE_CREATED]; ?>" class="regular-text" />

				<br><br>
			</div>

		</div>

<?php
	}
}
