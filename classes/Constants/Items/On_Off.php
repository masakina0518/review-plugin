<?php
namespace ReviewPlugin\Constants\Items;

use ReviewPlugin\Constants\Items\Enum;

/**
 * On_Off
 *
 * On_Off values
 */
final class On_Off extends Enum {

	const OFF	= '0';
	const ON	= '1';

	private static $NAME = [
		self::OFF	=> 'OFF',
		self::ON	=> 'ON',
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
