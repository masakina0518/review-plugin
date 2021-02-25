<?php
namespace ReviewPlugin\Constants\Items;

use ReviewPlugin\Constants\Items\Enum;

/**
 * Skin
 *
 * Skin values
 */
final class Skin extends Enum {

	const LIGHT	= '1';
	const DARK	= '2';

	private static $NAME = [
		self::LIGHT => 'LIGHT',
		self::DARK	=> 'DARK',
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
