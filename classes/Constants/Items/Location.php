<?php
namespace ReviewPlugin\Constants\Items;

use ReviewPlugin\Constants\Items\Enum;

/**
 * Location
 *
 * Location values
 */
final class Location extends Enum {

	const BOTTOM	= '1';
	const TOP		= '2';
	const TOPBOTTOM	= '3';
	const SHORTCODE = '4';

	private static $NAME = [
		self::BOTTOM	=> 'BOTTOM',
		self::TOP		=> 'TOP',
		self::TOPBOTTOM	=> 'TOP + BOTTOM',
		self::SHORTCODE => 'SHORTCODE',
	];

	private static $OUTPUT_GROUP = [
		'contents'	=> [self::BOTTOM, self::TOP, self::TOPBOTTOM],
		'shortcode'		=> [self::SHORTCODE]
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

	/**
	 * isShortcode
	 *
	 * @return boolean
	 */
	public function is_shortcode(): bool {
		if ( in_array( $this->getId(), self::$OUTPUT_GROUP['shortcode'], true ) ) {
			return true;
		}
		return false;
	}

	/**
	 * isContents
	 *
	 * @return boolean
	 */
	public function is_contents(): bool {
		if ( in_array( $this->getId(), self::$OUTPUT_GROUP['contents'], true ) ) {
			return true;
		}
		return false;
	}


}
