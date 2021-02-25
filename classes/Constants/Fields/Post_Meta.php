<?php

namespace ReviewPlugin\Constants\Fields;

use ReviewPlugin\Constants\Field_Prefix;

/**
 * Post_Meta
 *
 * WP_Postmeta_Feilds
 */
final class Post_Meta {

	/**
	 * @var string
	 */
	const ENABLE_REVIEW = Field_Prefix::POSTMETA.'enable_review';

	/**
	 * @var string
	 */
	const REVIEW_TYPE = Field_Prefix::POSTMETA.'review_type';

	/**
	 * @var string
	 */
	const FORMAT = Field_Prefix::POSTMETA.'format';

	/**
	 * @var string
	 */
	const LOCATION = Field_Prefix::POSTMETA.'location';

	/**
	 * @var string
	 */
	const DESIGN = Field_Prefix::POSTMETA.'design';

	/**
	 * @var string
	 */
	const EFFECT = Field_Prefix::POSTMETA.'effect';

	/**
	 * @var string
	 */
	const SKIN = Field_Prefix::POSTMETA.'skin';

	/**
	 * @var string
	 */
	const COLOR = Field_Prefix::POSTMETA.'color';

	/**
	 * @var string
	 */
	const USE_POST_TITLE = Field_Prefix::POSTMETA.'use_post_title';

	// /**
	//  * @var string
	//  */
	// const USE_FEATURED_IMAGE = Field_Prefix::POSTMETA.'use_featured_image';

	/**
	 * @var string
	 */
	const SCORE_SUBTITLE = Field_Prefix::POSTMETA.'score_subtitle';

	/**
	 * @var string
	 */
	const POSI_TITLE = Field_Prefix::POSTMETA.'posi_title';

	/**
	 * @var string
	 */
	const POSI_POINTS = Field_Prefix::POSTMETA.'posi_points';

	/**
	 * @var string
	 */
	const NEGA_TITLE = Field_Prefix::POSTMETA.'nega_title';

	/**
	 * @var string
	 */
	const NEGA_POINTS = Field_Prefix::POSTMETA.'nega_points';

	/**
	 * @var string
	 */
	const AFFILI_BLOCK_TITLE = Field_Prefix::POSTMETA.'affili_block_title';

	/**
	 * @var string
	 */
	const AFFILI_TITLE = Field_Prefix::POSTMETA.'affili_title';

	/**
	 * @var string
	 */
	const AFFILI_URL = Field_Prefix::POSTMETA.'affili_url';


	/**
	 * @var string
	 */
	const CONCLUSION_TITLE = Field_Prefix::POSTMETA.'conclusion_title';

	/**
	 * @var string
	 */
	const CONCLUSION_CONTENTS = Field_Prefix::POSTMETA.'conclusion_contents';

	// /**
	//  * @var string
	//  */
	// const GALLERY_BLOCK_TITLE = Field_Prefix::POSTMETA.'gallery_block_title';

	/**
	 * @var string
	 */
	const CRITERIAS = Field_Prefix::POSTMETA.'criterias';

	/**
	 * @var string
	 */
	const CRITERIA_SCORES = Field_Prefix::POSTMETA.'criteria_scores';

	/**
	 * @var string
	 */
	const CRITERIA_FINAL_SCORE = Field_Prefix::POSTMETA.'criteria_final_score';

	/**
	 * @var string
	 */
	const SCHEMA_TYPE = Field_Prefix::POSTMETA.'schema_type';

	/**
	 * @var string
	 */
	const SCHEMA_PROPERTIE_DESCRIPTION = Field_Prefix::POSTMETA.'schema_propertie_description';

	/**
	 * @var string
	 */
	const SCHEMA_PROPERTIE_SKU = Field_Prefix::POSTMETA.'schema_propertie_sku';

	/**
	 * @var string
	 */
	const SCHEMA_PROPERTIE_MPN = Field_Prefix::POSTMETA.'schema_propertie_mpn';

	/**
	 * @var string
	 */
	const SCHEMA_PROPERTIE_ISBN = Field_Prefix::POSTMETA.'schema_propertie_isbn';

	/**
	 * @var string
	 */
	const SCHEMA_PROPERTIE_BRAND = Field_Prefix::POSTMETA.'schema_propertie_brand';

	/**
	 * @var string
	 */
	const SCHEMA_PROPERTIE_DIRECTOR = Field_Prefix::POSTMETA.'schema_propertie_director';

	/**
	 * @var string
	 */
	const SCHEMA_PROPERTIE_DATE_CREATED = Field_Prefix::POSTMETA.'schema_propertie_date_created';


	/**
	 * convert_options
	 *
	 * @param string $postmeta_field
	 * @return string
	 */
	public static function convert_options( string $postmeta_field ): string {
		return str_replace( Field_Prefix::POSTMETA, Field_Prefix::OPTIONS, $postmeta_field );
	}
}

