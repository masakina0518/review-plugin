<?php
namespace ReviewPlugin\Constants\Items;

use ReviewPlugin\Constants\Items\Enum;

/**
 * Schema_Type
 *
 * Schema_Type values
 */
final class Schema_Type extends Enum {

	const ORGANIZATION	= '1';
	const PRODUCT		= '2';
	const EPISODE		= '3';
	const MOVIE			= '4';
	const GAME			= '5';

	private static $NAME = [
		self::ORGANIZATION	=> 'Organization',
		self::PRODUCT		=> 'Product',
		self::EPISODE		=> 'Episode',
		self::MOVIE			=> 'Movie',
		self::GAME			=> 'Game',
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
