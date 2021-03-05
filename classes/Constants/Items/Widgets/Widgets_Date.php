<?php
namespace ReviewPlugin\Constants\Items\Widgets;

use ReviewPlugin\Constants\Items\Enum;

/**
 * Widgets_Date
 *
 * Widgets_Date values
 */
final class Widgets_Date extends Enum {

	const ALL_TIME			= '1';
	const PAST_7_DAYS		= '2';
	const LAST_MONTH		= '3';

	private static $NAME = [
		self::ALL_TIME		=> 'All time',
		self::PAST_7_DAYS	=> 'Past 7 days',
		self::LAST_MONTH	=> 'Last month',
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
