<?php
namespace ReviewPlugin\Constants\Items;

use ReviewPlugin\Constants\Items\Enum;

/**
 * Design
 *
 * Design values
 */
final class Design extends Enum {

	const MINIMAL	= '1';

	private static $NAME = [
		self::MINIMAL	=> 'MINIMAL',
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
