<?php

namespace ReviewPlugin\Front\Outputs\Impl;

use ReviewPlugin\Admin\CustomFields\Review_Options;
use ReviewPlugin\Constants\Fields\Post_Meta;
use ReviewPlugin\Constants\Forms\Default_Values;
use ReviewPlugin\Constants\Items\Enum;
use ReviewPlugin\Constants\Items\On_Off;
use ReviewPlugin\Front\Outputs\Output;
use ReviewPlugin\Front\Views\View;

/**
 * Short_Code
 */
final class Short_Code implements Output {

	/**
	 * @var View
	 */
	private $view;

	/**
	 * @var string
	 */
	const NAME = 'review_plugin_shortcode';

	/**
	 * @var array
	 */
	const REVIEW_OPTIONS = Default_Values::REVIEW_OPTIONS;

	/**
	* @inheritDoc
	*/
	function __construct( View $view ) {
		$this->view = $view;
		$this->hooks();
	}

	/**
	* @inheritDoc
	*/
	public function hooks(): void {
		add_shortcode(
			self::NAME,
			array(
				$this,
				'create'
			)
		);
	}

	/**
	 * create
	 *
	 * @param mixed $attrs
	 * @return void
	 */
	public function create( $attrs ): string {
		$data = [];
		$output = '';
		$post_id = get_the_ID();
		$attrs = shortcode_atts(
			[],
			$attrs
		);

		foreach ( self::REVIEW_OPTIONS as $field => $value ) {
			// TODO:DBを直接いじられた場合の対応を検討したほうが良い
			$data[$field] = $value;
			$postmeta_val = get_post_meta( $post_id, $field, true );
			// Give priority to postmeta value
			if ( !is_null( $postmeta_val ) && !is_bool( $postmeta_val ) && '' !== $postmeta_val ) {
				$data[$field] = $postmeta_val;
			}
		}

		$enable_review_enum = Enum::factory(
			On_Off::class,
			$data[Post_Meta::ENABLE_REVIEW]
		);
		if ( $enable_review_enum->equals( On_Off::ON ) ) {
			$output = $this->view->create( $data );
		}
		return $output;
	}
}

