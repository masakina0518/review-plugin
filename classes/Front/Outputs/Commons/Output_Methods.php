<?php

namespace ReviewPlugin\Front\Outputs\Commons;

use ReviewPlugin\Constants\Forms\Default_Values;

/**
 * Output_Methods
 */
trait Output_Methods {

	/**
	 * get_data
	 *
	 * @param string $post_id
	 * @return array
	 */
	function get_data( $post_id ): array {
		$data = [];
		foreach ( Default_Values::REVIEW_OPTIONS as $field => $value ) {
			// TODO:DBを直接いじられた場合の対応を検討したほうが良い
			$data[$field] = $value;
			$postmeta_val = get_post_meta( $post_id, $field, true );
			// Give priority to postmeta value
			if ( !is_null( $postmeta_val ) && !is_bool( $postmeta_val ) && '' !== $postmeta_val ) {
				$data[$field] = $postmeta_val;
			}
		}
		return $data;
	}
}
