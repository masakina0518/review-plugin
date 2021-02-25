<?php

namespace ReviewPlugin\Admin\Views;

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
	const TITLE = 'Options';

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
	private $form_default_values = [
		Options::FORMAT => Format::PERCENT,
		Options::LOCATION => Location::BOTTOM,
		Options::DESIGN => Design::MINIMALIST,
		Options::EFFECT => Effect::NONE,
		Options::SKIN => Skin::LIGHT,
		Options::COLOR => '',
		Options::USE_POST_TITLE => On_Off::OFF,
		Options::USE_FEATURED_IMAGE => On_Off::OFF,
		Options::SCORE_SUBTITLE => '',
		Options::POSI_TITLE => '',
		Options::NEGA_TITLE => '',
		Options::AFFILI_BLOCK_TITLE => '',
		Options::CONCLUSION_TITLE => '',
		Options::GALLERY_BLOCK_TITLE => '',
		Options::CRITERIAS => ['aaaa', 'bbbb', 'ccccc' ],
		Options::CRITERIA_SCORES => [ 0, 0, 0 ],
	];

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
		$data['form'] = $this->form_default_values;
		foreach (  $this->form_default_values as $field => $value ) {
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
				$update_val = $this->form_default_values[$field];
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

	<div class="wrap">
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

		<h2>Format</h2>
		<?php foreach ( Format::getEnums() as $enum ): ?>
			<label><input name="<?php echo Options::FORMAT ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Options::FORMAT] ); ?> /><?php echo $enum->getName() ?></label><br />
		<?php endforeach; ?>

		<br>

		<h2>Location</h2>
		<?php foreach ( Location::getEnums() as $enum ): ?>
			<label><input name="<?php echo Options::LOCATION ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Options::LOCATION] ); ?> /><?php echo $enum->getName() ?></label><br />
		<?php endforeach; ?>

		<br>

		<h2>Design</h2>
		<?php foreach ( Design::getEnums() as $enum ): ?>
			<label><input name="<?php echo Options::DESIGN ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Options::DESIGN] ); ?> /><?php echo $enum->getName() ?></label><br />
		<?php endforeach; ?>

		<br>

		<h2>Animation Effect</h2>
		<?php foreach ( Effect::getEnums() as $enum ): ?>
			<label><input name="<?php echo Options::EFFECT ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Options::EFFECT] ); ?> /><?php echo $enum->getName() ?></label><br />
		<?php endforeach; ?>

		<br>

		<h2>Skin Style</h2>
		<?php foreach ( Skin::getEnums() as $enum ): ?>
			<label><input name="<?php echo Options::SKIN ?>" type="radio" value="<?php echo $enum->getId() ?>" <?php checked( $enum->getId(), $form[Options::SKIN] ); ?> /><?php echo $enum->getName() ?></label><br />
		<?php endforeach; ?>

		<br>

		<label for="<?php echo Options::COLOR ?>">Accent Color</label>
		<input name="<?php echo Options::COLOR ?>" type="text" id="<?php echo Options::COLOR ?>" value="<?php echo $form[Options::COLOR]; ?>" class="regular-text" />

		<br>
		<br>

		<label for="<?php echo Options::USE_POST_TITLE ?>">Use Post Title for Review Title</label>
		<input name="<?php echo Options::USE_POST_TITLE ?>" type="checkbox" id="<?php echo Options::USE_POST_TITLE ?>" value="1" <?php checked( On_Off::ON, $form[Options::USE_POST_TITLE] ); ?> />

		<br>
		<br>

		<label for="<?php echo Options::USE_FEATURED_IMAGE ?>">Use Featured Image as Main Review Image</label>
		<input name="<?php echo Options::USE_FEATURED_IMAGE ?>" type="checkbox" id="<?php echo Options::USE_FEATURED_IMAGE ?>" value="1" <?php checked( On_Off::ON, $form[Options::USE_FEATURED_IMAGE] ); ?> />

		<br>
		<br>

		<label for="<?php echo Options::SCORE_SUBTITLE ?>">Score Subtitle</label>
		<input name="<?php echo Options::SCORE_SUBTITLE ?>" type="text" id="<?php echo Options::SCORE_SUBTITLE ?>" value="<?php echo $form[Options::SCORE_SUBTITLE]; ?>" class="regular-text" />

		<br>
		<br>

		<label for="<?php echo Options::POSI_TITLE ?>">Positives Title</label>
		<input name="<?php echo Options::POSI_TITLE ?>" type="text" id="<?php echo Options::POSI_TITLE ?>" value="<?php echo $form[Options::POSI_TITLE]; ?>" class="regular-text" />

		<br>
		<br>

		<label for="<?php echo Options::NEGA_TITLE ?>">Negatives Title</label>
		<input name="<?php echo Options::NEGA_TITLE ?>" type="text" id="<?php echo Options::NEGA_TITLE ?>" value="<?php echo $form[Options::NEGA_TITLE]; ?>" class="regular-text" />

		<br>
		<br>

		<label for="<?php echo Options::AFFILI_BLOCK_TITLE ?>">Affiliate Block Title</label>
		<input name="<?php echo Options::AFFILI_BLOCK_TITLE ?>" type="text" id="<?php echo Options::AFFILI_BLOCK_TITLE ?>" value="<?php echo $form[Options::AFFILI_BLOCK_TITLE]; ?>" class="regular-text" />

		<br>
		<br>

		<label for="<?php echo Options::CONCLUSION_TITLE ?>">Conclusion Title</label>
		<input name="<?php echo Options::CONCLUSION_TITLE ?>" type="text" id="<?php echo Options::CONCLUSION_TITLE ?>" value="<?php echo $form[Options::CONCLUSION_TITLE]; ?>" class="regular-text" />

		<br>
		<br>

		<label for="<?php echo Options::GALLERY_BLOCK_TITLE ?>">Gallery Block Title</label>
		<input name="<?php echo Options::GALLERY_BLOCK_TITLE ?>" type="text" id="<?php echo Options::GALLERY_BLOCK_TITLE ?>" value="<?php echo $form[Options::GALLERY_BLOCK_TITLE]; ?>" class="regular-text" />

		<br>
		<br>

		<h2>Criterias</h2>
		<br>
		<div id="<?php echo Options::CRITERIAS; ?>">
			<?php foreach (  $form[Options::CRITERIAS] as $key => $value ): ?>
				<div>
					<input name="<?php echo Options::CRITERIAS.'[]'; ?>" type="text" id="<?php echo Options::CRITERIAS.$key ?>" value="<?php echo $value; ?>" class="regular-text" />
					<input name="<?php echo Options::CRITERIA_SCORES.'[]'; ?>" type="hidden" id="<?php echo Options::CRITERIA_SCORES.$key ?>" value="<?php echo $form[Options::CRITERIA_SCORES][$key]; ?>" class="regular-text" />
				</div>
				<br><br>
			<?php endforeach; ?>

			<script type="text/html" id="<?php echo Options::CRITERIAS; ?>_template">
				<div>
					<input name="<?php echo Options::CRITERIAS.'[]'; ?>" type="text" value="" class="regular-text" />
					<input name="<?php echo Options::CRITERIA_SCORES.'[]'; ?>" type="hidden"  value="0" class="regular-text" />
				</div>
				<br><br>
			</script>
		</div>


		<p><?php wp_nonce_field( $this->nonce_field ); ?> </p>
		<?php submit_button(); ?>
	</form>
	</div>

<?php
	}
}
