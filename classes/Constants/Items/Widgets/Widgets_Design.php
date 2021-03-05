<?php
namespace ReviewPlugin\Constants\Items\Widgets;

use ReviewPlugin\Constants\Items\Enum;

/**
 * Widgets_Design
 *
 * Widgets_Design values
 */
final class Widgets_Design extends Enum {

	const MINIMAL		= '1';
	const BOLD			= '2';
	const SIMPLE		= '3';
	const SIMPLE_STAR 	= '4';

	private static $NAME = [
		self::MINIMAL		=> 'MINIMAL',
		self::BOLD			=> 'BOLD',
		self::SIMPLE		=> 'SIMPLE',
		self::SIMPLE_STAR 	=> 'SIMPLE + STAR',
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
