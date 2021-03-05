<?php

namespace ReviewPlugin\Constants\Forms;

use ReviewPlugin\Constants\Fields\Options;
use ReviewPlugin\Constants\Fields\Post_Meta;
use ReviewPlugin\Constants\Fields\Widgets\Options_Review_Lists;
use ReviewPlugin\Constants\Items\Design;
use ReviewPlugin\Constants\Items\Effect;
use ReviewPlugin\Constants\Items\Format;
use ReviewPlugin\Constants\Items\On_Off;
use ReviewPlugin\Constants\Items\Review_Type;
use ReviewPlugin\Constants\Items\Location;
use ReviewPlugin\Constants\Items\Skin;
use ReviewPlugin\Constants\Items\Schema_Type;
use ReviewPlugin\Constants\Items\Widgets\Widgets_Date;
use ReviewPlugin\Constants\Items\Widgets\Widgets_Design;
use ReviewPlugin\Constants\Items\Widgets\Widgets_Order;
use ReviewPlugin\Constants\Items\Widgets\Widgets_Score_Type;
use ReviewPlugin\Constants\Items\Widgets\Widgets_Source;

/**
 * Default_Values
 */
final class Default_Values {

	/**
	 * @var array
	 */
	const DEFAILT_VALUES = [
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
	 * @var array
	 */
	CONST REVIEW_OPTIONS = [
		Post_Meta::ENABLE_REVIEW => On_Off::OFF,
		Post_Meta::USE_POST_TITLE => On_Off::OFF,
		Post_Meta::POST_TITLE => '',
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
		Post_Meta::SCHEMA_TYPE => Schema_Type::ORGANIZATION,
		Post_Meta::SCHEMA_PROPERTIE_DESCRIPTION => '',
		Post_Meta::SCHEMA_PROPERTIE_SKU => '',
		Post_Meta::SCHEMA_PROPERTIE_MPN => '',
		Post_Meta::SCHEMA_PROPERTIE_ISBN => '',
		Post_Meta::SCHEMA_PROPERTIE_BRAND => '',
		Post_Meta::SCHEMA_PROPERTIE_DIRECTOR => '',
		Post_Meta::SCHEMA_PROPERTIE_DATE_CREATED => '',
	];

	/**
	 * @var array
	 */
	CONST WIDGESTS_REVIEW_LISTS = [
		Options_Review_Lists::TITLE => 'タイトル',
		Options_Review_Lists::AMOUNT => '5',
		Options_Review_Lists::SOURCE => Widgets_Source::CATEGORIES,
		Options_Review_Lists::SOURCE_CATEGORYIES => '',
		Options_Review_Lists::SOURCE_TAGS => '',
		Options_Review_Lists::SOURCE_POSTS => '',
		Options_Review_Lists::SOURCE_CUSTOM_POST_TYPES => '',
		Options_Review_Lists::CATEGORIES => '',
		Options_Review_Lists::DATE => Widgets_Date::ALL_TIME,
		Options_Review_Lists::DESIGN => Widgets_Design::MINIMAL,
		Options_Review_Lists::ORDER => Widgets_Order::TOP_SCORES,
		Options_Review_Lists::SCORE_TYPE => Widgets_Score_Type::EDIT_SCORES,
	];
}

