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
	const STYLE_NAME = 'admin';

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
			self::STYLE_NAME,
			$this->pm->getAdminStylePath(
				self::STYLE_NAME
			)
		);
		wp_enqueue_style(
			'wp-color-picker',
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
		wp_enqueue_script(
			'jquery-ui-tabs',
			array(
				'jquery'
			)
		);
		wp_enqueue_script(
			'wp-color-picker',
			array(
				'jquery'
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
	<div id="<?php echo Review_Options::ID ?>_wrappar">
		<table class="form-table">
			<tr>
				<th>Enable review</th>
				<td>
					<fieldset>
						<?php foreach ( On_Off::getEnums() as $enum ): ?>
							<label><input name="<?php echo Post_Meta::ENABLE_REVIEW ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Post_Meta::ENABLE_REVIEW] ); ?> /><?php echo $enum->getName() ?></label>&nbsp;
						<?php endforeach; ?>
					</fieldset>
				</td>
			</tr>
		</table>
		<div id="<?php echo Review_Options::ID ?>_input_field">
			<div class="nav-tab-wrapper">
				<ul class="nav-tab-container">
					<li><a class="nav-tab nav-tab-active" href="#<?php echo Review_Options::ID ?>_general">GENERAL</a></li>
					<li><a class="nav-tab" href="#<?php echo Review_Options::ID ?>_fields">FIELDS</a></li>
					<li><a class="nav-tab" href="#<?php echo Review_Options::ID ?>_design">DESIGN</a></li>
					<li><a class="nav-tab" href="#<?php echo Review_Options::ID ?>_affiliate">AFFILIATE</a></li>
					<li><a class="nav-tab" href="#<?php echo Review_Options::ID ?>_schema_type">SCHEMA TYPE</a></li>
				</ul>
			</div>
			<div id="<?php echo Review_Options::ID ?>_general">

				<h1>GENERAL</h1>
				<table class="form-table">
					<tr>
						<th>Use post title</th>
						<td>
							<fieldset>
								<label><input name="<?php echo Post_Meta::USE_POST_TITLE ?>" id="<?php echo Post_Meta::USE_POST_TITLE ?>" type="checkbox" value="<?php echo On_Off::ON ?>" <?php checked( On_Off::ON, $form[Post_Meta::USE_POST_TITLE] ); ?> /><?php echo $enum->getName() ?></label>
								<br>
								<input name="<?php echo Post_Meta::POST_TITLE ?>" type="text" id="<?php echo Post_Meta::POST_TITLE ?>" value="<?php echo $form[Post_Meta::POST_TITLE]; ?>" class="regular-text" />
							</fieldset>
						</td>
					</tr>
					<tr>
						<th>Location</th>
						<td>
							<fieldset>
								<?php foreach ( Location::getEnums() as $enum ): ?>
									<label><input name="<?php echo Post_Meta::LOCATION ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Post_Meta::LOCATION] ); ?> /><?php echo $enum->getName() ?></label><br>
								<?php endforeach; ?>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th>Format</th>
						<td>
							<fieldset>
								<?php foreach ( Format::getEnums() as $enum ): ?>
									<label><input name="<?php echo Post_Meta::FORMAT ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Post_Meta::FORMAT] ); ?> /><?php echo $enum->getName() ?></label><br>
								<?php endforeach; ?>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th>Score Subtitle</th>
						<td>
							<fieldset>
								<input name="<?php echo Post_Meta::SCORE_SUBTITLE ?>" type="text" id="<?php echo Post_Meta::SCORE_SUBTITLE ?>" value="<?php echo $form[Post_Meta::SCORE_SUBTITLE]; ?>" class="regular-text" />
							</fieldset>
						</td>
					</tr>
					<tr>
						<th>Conclusion Title</th>
						<td>
							<fieldset>
								<input name="<?php echo Post_Meta::CONCLUSION_TITLE ?>" type="text" id="<?php echo Post_Meta::CONCLUSION_TITLE ?>" value="<?php echo $form[Post_Meta::CONCLUSION_TITLE]; ?>" class="regular-text" />
							</fieldset>
						</td>
					</tr>
					<tr>
						<th>Conclusion Contents</th>
						<td>
							<fieldset>
								<textarea name="<?php echo Post_Meta::CONCLUSION_CONTENTS ?>" id="<?php echo Post_Meta::CONCLUSION_CONTENTS ?>" class="regular-text" rows="10"><?php echo $form[Post_Meta::CONCLUSION_CONTENTS]; ?></textarea>
							</fieldset>
						</td>
					</tr>
				</table>
			</div>

			<div id="<?php echo Review_Options::ID ?>_fields">
				<h1>FIELDS</h1>

				<table class="form-table">
					<tr>
						<th>Criterias</th>
						<td>
							<fieldset>
								<div id="<?php echo Post_Meta::CRITERIAS; ?>_form">
									<?php foreach ( $form[Post_Meta::CRITERIAS] as $key => $value ): ?>
										<div>
											<div class="slider" style="width: 90%; height: 5px;"></div>

											<input name="<?php echo Post_Meta::CRITERIAS.'[]'; ?>" type="text" id="<?php echo Post_Meta::CRITERIAS.$key ?>" value="<?php echo $value; ?>" class="regular-text" />
											<input name="<?php echo Post_Meta::CRITERIA_SCORES.'[]'; ?>" type="number" id="<?php echo Post_Meta::CRITERIA_SCORES.$key ?>" value="<?php echo $form[Post_Meta::CRITERIA_SCORES][$key]; ?>" class="small-text" min="0" max="100" />
											<input type="button" class="<?php echo Post_Meta::CRITERIAS ?>_delete button button-primary" value="Delete" />
											<br><br>
										</div>
									<?php endforeach; ?>

									<script type="text/html" id="<?php echo Post_Meta::CRITERIAS; ?>_template">
										<div>
											<input name="<?php echo Post_Meta::CRITERIAS.'[]'; ?>" type="text" value="" class="regular-text" />
											<input name="<?php echo Post_Meta::CRITERIA_SCORES.'[]'; ?>" type="number" value="0" class="small-text" min="0" max="100" />
											<input type="button" class="<?php echo Post_Meta::CRITERIAS ?>_delete button button-primary" value="Delete" />
											<br><br>
										</div>
									</script>

									<div id="<?php echo Post_Meta::CRITERIA_FINAL_SCORE; ?>_form">
										<label for="<?php echo Post_Meta::CRITERIA_FINAL_SCORE; ?>">Final Score</label>&nbsp;<input name="<?php echo Post_Meta::CRITERIA_FINAL_SCORE; ?>" type="number" id="<?php echo Post_Meta::CRITERIA_FINAL_SCORE ?>" value="<?php echo $form[Post_Meta::CRITERIA_FINAL_SCORE]; ?>" class="small-text" min="0" max="100" />
										<br><br>
									</div>
									<input type="button" id="<?php echo Post_Meta::CRITERIAS ?>_add" class="button button-primary" value="Add">
								</div>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th>Positives</th>
						<td>
							<fieldset>
								<input name="<?php echo Post_Meta::POSI_TITLE ?>" type="text" id="<?php echo Post_Meta::POSI_TITLE ?>" value="<?php echo $form[Post_Meta::POSI_TITLE]; ?>" class="regular-text" />
								<br><br>
								<div id="<?php echo Post_Meta::POSI_POINTS; ?>_form">
									<?php foreach ( $form[Post_Meta::POSI_POINTS] as $key => $value ): ?>
										<div>
											＋&nbsp;<input name="<?php echo Post_Meta::POSI_POINTS.'[]'; ?>" type="text" id="<?php echo Post_Meta::POSI_POINTS.$key ?>" value="<?php echo $value; ?>" class="regular-text" />
											<input type="button" class="<?php echo Post_Meta::POSI_POINTS ?>_delete button button-primary" value="Delete" />
											<br><br>
										</div>
									<?php endforeach; ?>

									<script type="text/html" id="<?php echo Post_Meta::POSI_POINTS; ?>_template">
										<div>
											＋&nbsp;<input name="<?php echo Post_Meta::POSI_POINTS.'[]'; ?>" type="text" value="" class="regular-text" />
											<input type="button" class="<?php echo Post_Meta::POSI_POINTS ?>_delete button button-primary" value="Delete" />
											<br><br>
										</div>
									</script>
									<input type="button" id="<?php echo Post_Meta::POSI_POINTS ?>_add" class="button button-primary" value="Add">
								</div>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th>Negatives</th>
						<td>
							<fieldset>
								<input name="<?php echo Post_Meta::NEGA_TITLE ?>" type="text" id="<?php echo Post_Meta::NEGA_TITLE ?>" value="<?php echo $form[Post_Meta::NEGA_TITLE]; ?>" class="regular-text" />
								<br><br>
								<div id="<?php echo Post_Meta::NEGA_POINTS; ?>_form">
									<?php foreach ( $form[Post_Meta::NEGA_POINTS] as $key => $value ): ?>
										<div>
											－&nbsp;<input name="<?php echo Post_Meta::NEGA_POINTS.'[]'; ?>" type="text" id="<?php echo Post_Meta::NEGA_POINTS.$key ?>" value="<?php echo $value; ?>" class="regular-text" />
											<input type="button" class="<?php echo Post_Meta::NEGA_POINTS ?>_delete button button-primary" value="Delete" />
											<br><br>
										</div>
									<?php endforeach; ?>

									<script type="text/html" id="<?php echo Post_Meta::NEGA_POINTS; ?>_template">
										<div>
											－&nbsp;<input name="<?php echo Post_Meta::NEGA_POINTS.'[]'; ?>" type="text" value="" class="regular-text" />
											<input type="button" class="<?php echo Post_Meta::NEGA_POINTS ?>_delete button button-primary" value="Delete" />
											<br><br>
										</div>
									</script>
									<input type="button" id="<?php echo Post_Meta::NEGA_POINTS ?>_add" class="button button-primary" value="Add">
								</div>
							</fieldset>
						</td>
					</tr>
				</table>
			</div>

			<div id="<?php echo Review_Options::ID ?>_design">
				<h1>DESIGN</h1>

				<table class="form-table">
					<tr>
						<th>Design</th>
						<td>
							<fieldset>
								<?php foreach ( Design::getEnums() as $enum ): ?>
									<label><input name="<?php echo Post_Meta::DESIGN ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Post_Meta::DESIGN] ); ?> /><?php echo $enum->getName() ?></label><br>
								<?php endforeach; ?>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th>Effect</th>
						<td>
							<fieldset>
								<?php foreach ( Effect::getEnums() as $enum ): ?>
									<label><input name="<?php echo Post_Meta::EFFECT ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Post_Meta::EFFECT] ); ?> /><?php echo $enum->getName() ?></label><br>
								<?php endforeach; ?>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th>Skin</th>
						<td>
							<fieldset>
								<?php foreach ( Skin::getEnums() as $enum ): ?>
									<label><input name="<?php echo Post_Meta::SKIN ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Post_Meta::SKIN] ); ?> /><?php echo $enum->getName() ?></label><br>
								<?php endforeach; ?>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th>Color</th>
						<td>
							<fieldset>
								<input name="<?php echo Post_Meta::COLOR ?>" type="text" id="<?php echo Post_Meta::COLOR ?>" value="<?php echo $form[Post_Meta::COLOR]; ?>" />
							</fieldset>
						</td>
					</tr>
				</table>
			</div>

			<div id="<?php echo Review_Options::ID ?>_affiliate">
				<h1>AFFILIATE</h1>

				<table class="form-table">
					<tr>
						<th>Affliate block title</th>
						<td>
							<fieldset>
								<input name="<?php echo Post_Meta::AFFILI_BLOCK_TITLE ?>" type="text" id="<?php echo Post_Meta::AFFILI_BLOCK_TITLE ?>" value="<?php echo $form[Post_Meta::AFFILI_BLOCK_TITLE]; ?>" class="regular-text" />
							</fieldset>
						</td>
					</tr>
					<tr>
						<th>Affliate list</th>
						<td>
							<fieldset>
								<div id="<?php echo Post_Meta::AFFILI_TITLE; ?>_form">
									<?php foreach ( $form[Post_Meta::AFFILI_TITLE] as $key => $value ): ?>
										<div>
											<label for="<?php echo Post_Meta::AFFILI_TITLE.$key ?>">TITLE
												<input name="<?php echo Post_Meta::AFFILI_TITLE.'[]'; ?>" type="text" id="<?php echo Post_Meta::AFFILI_TITLE.$key ?>" value="<?php echo $value; ?>" class="regular-text" />
											</label>
											<label for="<?php echo Post_Meta::AFFILI_URL.$key ?>">URL
												<input name="<?php echo Post_Meta::AFFILI_URL.'[]'; ?>" type="text" id="<?php echo Post_Meta::AFFILI_URL.$key ?>" value="<?php echo $form[Post_Meta::AFFILI_URL][$key]; ?>" class="regular-text" />
											</label>
											<input type="button" class="<?php echo Post_Meta::AFFILI_TITLE ?>_delete button button-primary" value="Delete" />
											<br />
										</div>
									<?php endforeach; ?>

									<script type="text/html" id="<?php echo Post_Meta::AFFILI_TITLE; ?>_template">
										<div>
											<label>TITLE
												<input name="<?php echo Post_Meta::AFFILI_TITLE.'[]'; ?>" type="text" value="" class="regular-text" />
											</label>
											<label>URL
												<input name="<?php echo Post_Meta::AFFILI_URL.'[]'; ?>" type="text" value="" class="regular-text" />
											</label>
											<input type="button" class="<?php echo Post_Meta::AFFILI_TITLE ?>_delete button button-primary" value="Delete" />
											<br />
										</div>
									</script>
									<input type="button" id="<?php echo Post_Meta::AFFILI_TITLE ?>_add" class="button button-primary" value="Add">
								</div>
							</fieldset>
						</td>
					</tr>
				</table>
			</div>

			<div id="<?php echo Review_Options::ID ?>_schema_type">
				<h1>SCHEMA TYPE</h1>

				<table class="form-table">
					<tr>
						<th>Schema type</th>
						<td>
							<fieldset>
								<select name="<?php echo Post_Meta::SCHEMA_TYPE ?>" id="<?php echo Post_Meta::SCHEMA_TYPE ?>">
									<?php foreach( Schema_Type::getEnums() as $enum ): ?>
										<option value="<?php echo $enum->getId(); ?>" <?php selected( $enum->getId(), $form[Post_Meta::SCHEMA_TYPE] ); ?> ><?php echo $enum->getName(); ?></option>
									<?php endforeach; ?>
								</select>
							</fieldset>
						</td>
					</tr>
					<tr id="<?php echo Post_Meta::SCHEMA_TYPE; ?>_2">
						<th>Schema properties</th>
						<td>
							<fieldset>
								<div>
									<label for="<?php echo Post_Meta::SCHEMA_PROPERTIE_DESCRIPTION ?>">DESCRIPTION
										<input name="<?php echo Post_Meta::SCHEMA_PROPERTIE_DESCRIPTION ?>" type="text" id="<?php echo Post_Meta::SCHEMA_PROPERTIE_DESCRIPTION ?>" value="<?php echo $form[Post_Meta::SCHEMA_PROPERTIE_DESCRIPTION]; ?>" class="regular-text" />
									</label>
									<br />
									<label for="<?php echo Post_Meta::SCHEMA_PROPERTIE_SKU ?>">SKU
										<input name="<?php echo Post_Meta::SCHEMA_PROPERTIE_SKU ?>" type="text" id="<?php echo Post_Meta::SCHEMA_PROPERTIE_SKU ?>" value="<?php echo $form[Post_Meta::SCHEMA_PROPERTIE_SKU]; ?>" class="regular-text" />
									</label>
									<br />
									<label for="<?php echo Post_Meta::SCHEMA_PROPERTIE_MPN ?>">MPN
										<input name="<?php echo Post_Meta::SCHEMA_PROPERTIE_MPN ?>" type="text" id="<?php echo Post_Meta::SCHEMA_PROPERTIE_MPN ?>" value="<?php echo $form[Post_Meta::SCHEMA_PROPERTIE_MPN]; ?>" class="regular-text" />
									</label>
									<br />
									<label for="<?php echo Post_Meta::SCHEMA_PROPERTIE_ISBN ?>">ISBN
										<input name="<?php echo Post_Meta::SCHEMA_PROPERTIE_ISBN ?>" type="text" id="<?php echo Post_Meta::SCHEMA_PROPERTIE_ISBN ?>" value="<?php echo $form[Post_Meta::SCHEMA_PROPERTIE_ISBN]; ?>" class="regular-text" />
									</label>
									<br />
									<label for="<?php echo Post_Meta::SCHEMA_PROPERTIE_BRAND ?>">BRAND
										<input name="<?php echo Post_Meta::SCHEMA_PROPERTIE_BRAND ?>" type="text" id="<?php echo Post_Meta::SCHEMA_PROPERTIE_BRAND ?>" value="<?php echo $form[Post_Meta::SCHEMA_PROPERTIE_BRAND]; ?>" class="regular-text" />
									</label>
								</div>
							</fieldset>
						</td>
					</tr>
					<tr id="<?php echo Post_Meta::SCHEMA_TYPE; ?>_4">
						<th>Schema properties</th>
						<td>
							<fieldset>

								<div>
									<label for="<?php echo Post_Meta::SCHEMA_PROPERTIE_DIRECTOR ?>">DIRECTOR
										<input name="<?php echo Post_Meta::SCHEMA_PROPERTIE_DIRECTOR ?>" type="text" id="<?php echo Post_Meta::SCHEMA_PROPERTIE_DIRECTOR ?>" value="<?php echo $form[Post_Meta::SCHEMA_PROPERTIE_DIRECTOR]; ?>" class="regular-text" />
									</label>
									<label for="<?php echo Post_Meta::SCHEMA_PROPERTIE_DATE_CREATED ?>">DATE CREATED
										<input name="<?php echo Post_Meta::SCHEMA_PROPERTIE_DATE_CREATED ?>" type="text" id="<?php echo Post_Meta::SCHEMA_PROPERTIE_DATE_CREATED ?>" value="<?php echo $form[Post_Meta::SCHEMA_PROPERTIE_DATE_CREATED]; ?>" class="regular-text" />
									</label>
								</div>
							</fieldset>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
<?php
	}
}
