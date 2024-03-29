<?php
namespace ReviewPlugin\Constants\Items;

use ReviewPlugin\Constants\Items\Enum;

/**
 * Format
 *
 * Format values
 */
final class Format extends Enum {

	const PERCENT	= '1';
	const POINTS	= '2';
	const STARS		= '3';

	private static $NAME = [
		self::PERCENT	=> 'PERCENT',
		self::POINTS	=> 'POINTS',
		self::STARS		=> 'STARS'
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
