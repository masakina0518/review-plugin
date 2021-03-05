<?php
namespace ReviewPlugin\Constants\Items\Widgets;

use ReviewPlugin\Constants\Items\Enum;

/**
 * Widgets_Source
 *
 * Widgets_Source values
 */
final class Widgets_Source extends Enum {

	const CATEGORIES			= '1';
	const TAGS					= '2';
	const POSTS					= '3';
	const CUSTOM_POST_TYPES		= '4';

	private static $NAME = [
		self::CATEGORIES		=> 'Categoryies',
		self::TAGS				=> 'Tags',
		self::POSTS				=> 'Posts',
		self::CUSTOM_POST_TYPES	=> 'Custom post types',
	];

	/**
	 * @var string Name
	 */
	private $name;

	/**
	 * __construct
	 *
	 * @param mixed $id
	 */
	public function __construct( $id ) {
		parent::__construct( $id );
		$this->name = self::$NAME[$id];
	}

	/**
	 * getName
	 *
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}
}
