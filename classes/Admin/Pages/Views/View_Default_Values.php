<?php

namespace ReviewPlugin\Admin\Pages\Views;

use ReviewPlugin\Constants\Forms\Default_Values;
use ReviewPlugin\Constants\Fields\Options;
use ReviewPlugin\Constants\Items\Format;
use ReviewPlugin\Constants\Items\Location;
use ReviewPlugin\Constants\Items\Design;
use ReviewPlugin\Constants\Items\Effect;
use ReviewPlugin\Constants\Items\Skin;
use ReviewPlugin\Constants\Items\On_Off;

/**
 * View_Default_Values
 */
final class View_Default_Values {

	/**
	 * @var string
	 */
	const TITLE = 'Default Values';

	/**
	 * @var string
	 */
	const SLUG = 'review_plugin_default_values';

	/**
	 * @var string
	 */
	private $nonce_field = 'review_plugin_default_values';

	/**
	 * @var array
	 */
	const FORM_DEFAULT_VALUES = Default_Values::DEFAILT_VALUES;

	/**
	 * __construct
	 */
	function __construct() {
		$data = [];
		$data = $this->initialize( $data );
		$data = $this->post( $data );
		$this->display( $data );
	}

	/**
	 * initialize
	 *
	 * @param array $data
	 * @return array
	 */
	private function initialize( array $data ): array {
		$data['form'] = self::FORM_DEFAULT_VALUES;
		foreach ( self::FORM_DEFAULT_VALUES as $field => $value ) {
			if( $current_val = get_option( $field ) ) {
				$data['form'][$field] = $current_val;
			}
		}
		return $data;
	}


	/**
	 * post
	 *
	 * @param array $data
	 * @return array
	 */
	private function post( array $data ): array {
		$post_data = stripslashes_deep( $_POST );
		if ( $post_data ) {
			$data['success'] = false;
			$data = $this->validate( $data, $post_data );
			if( $data['error'] ) {
				return $data;
			}
			check_admin_referer( $this->nonce_field );
			foreach ( $data['form'] as $field => $value ) {
				/* In the case not set value, to change at default value. */
				$update_val = self::FORM_DEFAULT_VALUES[$field];
				if ( array_key_exists( $field, $post_data ) ) {
					$update_val = $post_data[$field];
				}
				update_option( $field, $update_val );
				$data['form'][$field] = $update_val;
			}
			$data['success'] = true;
		}
		return $data;
	}

	/**
	 * validate
	 *
	 * @param array $data
	 * @return array
	 */
	private function validate( array $data, array $post_data ): array {
		$data['error'] = null;
		foreach ($data['form'] as $field => $value) {
			// TODO:いつか書く
		}
		return $data;
	}

	/**
	 * display
	 *
	 * @return void
	 */
	public function display( array $data ): void {
		extract( $data );
?>

	<div id="<?php echo View_Default_Values::SLUG ?>_wrappar">
	<h1><?php echo self::TITLE; ?></h1>

	<?php if (isset( $success ) && $success ): ?>
		<div class="notice notice-success is-dismissible">
			<p>
				<strong>設定を保存しました。</strong>
			</p>
			<button type="button" class="notice-dismiss">
			<span class="screen-reader-text">この通知を非表示にする</span></button>
		</div>
	<?php endif; ?>

	<?php if (isset( $error ) && $error ): ?>
		<div class="notice notice-error is-dismissible">
			<p>
				<strong>設定に失敗しました。</strong>
			</p>
			<button type="button" class="notice-dismiss">
			<span class="screen-reader-text">この通知を非表示にする</span></button>
		</div>
	<?php endif; ?>

		<form method="post" action="">
			<table class="form-table">
				<tr>
					<th>Format</th>
					<td>
						<fieldset>
							<?php foreach ( Format::getEnums() as $enum ): ?>
								<label><input name="<?php echo Options::FORMAT ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Options::FORMAT] ); ?> /><?php echo $enum->getName() ?></label>&nbsp;
							<?php endforeach; ?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>Location</th>
					<td>
						<fieldset>
							<?php foreach ( Location::getEnums() as $enum ): ?>
								<label><input name="<?php echo Options::LOCATION ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Options::LOCATION] ); ?> /><?php echo $enum->getName() ?></label>&nbsp;
							<?php endforeach; ?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>Design</th>
					<td>
						<fieldset>
							<?php foreach ( Design::getEnums() as $enum ): ?>
								<label><input name="<?php echo Options::DESIGN ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Options::DESIGN] ); ?> /><?php echo $enum->getName() ?></label>&nbsp;
							<?php endforeach; ?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>Animation Effect</th>
					<td>
						<fieldset>
							<?php foreach ( Effect::getEnums() as $enum ): ?>
								<label><input name="<?php echo Options::EFFECT ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Options::EFFECT] ); ?> /><?php echo $enum->getName() ?></label>&nbsp;
							<?php endforeach; ?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>Skin Style</th>
					<td>
						<fieldset>
							<?php foreach ( Skin::getEnums() as $enum ): ?>
								<label><input name="<?php echo Options::SKIN ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Options::SKIN] ); ?> /><?php echo $enum->getName() ?></label>&nbsp;
							<?php endforeach; ?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>Accent Color</th>
					<td>
						<fieldset>
							<input name="<?php echo Options::COLOR ?>" type="text" id="<?php echo Options::COLOR ?>" value="<?php echo $form[Options::COLOR]; ?>" class="regular-text" />
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>Use Post Title for Review Title</th>
					<td>
						<fieldset>
							<input name="<?php echo Options::USE_POST_TITLE ?>" type="checkbox" id="<?php echo Options::USE_POST_TITLE ?>" value="1" <?php checked( On_Off::ON, $form[Options::USE_POST_TITLE] ); ?> />
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>Use Featured Image as Main Review Image</th>
					<td>
						<fieldset>
							<input name="<?php echo Options::USE_FEATURED_IMAGE ?>" type="checkbox" id="<?php echo Options::USE_FEATURED_IMAGE ?>" value="1" <?php checked( On_Off::ON, $form[Options::USE_FEATURED_IMAGE] ); ?> />
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>Score Subtitle</th>
					<td>
						<fieldset>
							<input name="<?php echo Options::SCORE_SUBTITLE ?>" type="text" id="<?php echo Options::SCORE_SUBTITLE ?>" value="<?php echo $form[Options::SCORE_SUBTITLE]; ?>" class="regular-text" />
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>Positives Block Title</th>
					<td>
						<fieldset>
							<input name="<?php echo Options::POSI_TITLE ?>" type="text" id="<?php echo Options::POSI_TITLE ?>" value="<?php echo $form[Options::POSI_TITLE]; ?>" class="regular-text" />
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>Negatives Block Title</th>
					<td>
						<fieldset>
							<input name="<?php echo Options::NEGA_TITLE ?>" type="text" id="<?php echo Options::NEGA_TITLE ?>" value="<?php echo $form[Options::NEGA_TITLE]; ?>" class="regular-text" />
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>Affiliate Block Title</th>
					<td>
						<fieldset>
							<input name="<?php echo Options::AFFILI_BLOCK_TITLE ?>" type="text" id="<?php echo Options::AFFILI_BLOCK_TITLE ?>" value="<?php echo $form[Options::AFFILI_BLOCK_TITLE]; ?>" class="regular-text" />

						</fieldset>
					</td>
				</tr>
				<tr>
					<th>Conclusion Title</th>
					<td>
						<fieldset>
							<input name="<?php echo Options::CONCLUSION_TITLE ?>" type="text" id="<?php echo Options::CONCLUSION_TITLE ?>" value="<?php echo $form[Options::CONCLUSION_TITLE]; ?>" class="regular-text" />
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>Gallery Block Title(not use)</th>
					<td>
						<fieldset>
							<input name="<?php echo Options::GALLERY_BLOCK_TITLE ?>" type="text" id="<?php echo Options::GALLERY_BLOCK_TITLE ?>" value="<?php echo $form[Options::GALLERY_BLOCK_TITLE]; ?>" class="regular-text" />
						</fieldset>
					</td>
				</tr>
				<tr>
					<th>Criterias</th>
					<td>
						<fieldset>
							<div id="<?php echo Options::CRITERIAS; ?>_form">
								<?php foreach (  $form[Options::CRITERIAS] as $key => $value ): ?>
									<div class="<?php echo Options::CRITERIAS; ?>_box">
										<input name="<?php echo Options::CRITERIAS.'[]'; ?>" type="text" id="<?php echo Options::CRITERIAS.$key ?>" value="<?php echo $value; ?>" class="regular-text" />
										<input name="<?php echo Options::CRITERIA_SCORES.'[]'; ?>" type="number" id="<?php echo Options::CRITERIA_SCORES.$key ?>" value="<?php echo $form[Options::CRITERIA_SCORES][$key]; ?>" class="small-text"  min="0" max="100" readonly="readonly" />
										<input type="button" class="<?php echo Options::CRITERIAS ?>_delete button button-primary" value="Delete" />
										<br><br>
									</div>
								<?php endforeach; ?>

								<script type="text/html" id="<?php echo Options::CRITERIAS; ?>_template">
									<div class="<?php echo Options::CRITERIAS; ?>_box">
										<input name="<?php echo Options::CRITERIAS.'[]'; ?>" type="text" value="" class="regular-text" />
										<input name="<?php echo Options::CRITERIA_SCORES.'[]'; ?>" type="number" value="0" class="small-text" min="0" max="100" readonly="readonly" />
										<input type="button" class="<?php echo Options::CRITERIAS ?>_delete button button-primary" value="Delete" />
										<br><br>
									</div>
								</script>
								<input type="button" id="<?php echo Options::CRITERIAS ?>_add" class="button button-primary" value="Add">
							</div>
						</fieldset>
					</td>
				</tr>
			</table>

			<?php wp_nonce_field( $this->nonce_field ); ?>
			<?php submit_button(); ?>
		</form>
	</div>

<?php
	}
}
