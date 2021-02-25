<?php
namespace ReviewPlugin\Constants\Items;

use ReviewPlugin\Constants\Items\Enum;

/**
 * Effect
 *
 * Effect values
 */
final class Effect extends Enum {

	const NONE			= '1';
	const INCREMENTAL	= '2';
	const FADE_IN		= '3';

	private static $NAME = [
		self::NONE			=> 'NONE',
		self::INCREMENTAL	=> 'INCREMENTAL',
		self::FADE_IN		=> 'FADE_IN',
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
