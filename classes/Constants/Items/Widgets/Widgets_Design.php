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

	private static $NAME = [
		self::MINIMAL		=> 'MINIMAL',
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
