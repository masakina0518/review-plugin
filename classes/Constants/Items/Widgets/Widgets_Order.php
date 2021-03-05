<?php
namespace ReviewPlugin\Constants\Items\Widgets;

use ReviewPlugin\Constants\Items\Enum;

/**
 * Widgets_Order
 *
 * Widgets_Order values
 */
final class Widgets_Order extends Enum {

	const TOP_SCORES		= '1';
	const LOWEST_SCORES		= '2';
	const NEWEST_REVIEWS	= '3';

	private static $NAME = [
		self::TOP_SCORES		=> 'Top scores',
		self::LOWEST_SCORES	=> 'Lowest scores',
		self::NEWEST_REVIEWS	=> 'Newest reviews',
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
