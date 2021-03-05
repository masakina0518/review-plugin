<?php
namespace ReviewPlugin\Constants\Items\Widgets;

use ReviewPlugin\Constants\Items\Enum;

/**
 * Widgets_Score_Type
 *
 * Widgets_Score_Type values
 */
final class Widgets_Score_Type extends Enum {

	const EDIT_SCORES			= '1';
	const VISITOR_SCORES		= '2';
	const COMMENT_REVIEW_SCORES	= '3';

	private static $NAME = [
		self::EDIT_SCORES			=> 'Edit scores',
		self::VISITOR_SCORES		=> 'Vistor scores',
		self::COMMENT_REVIEW_SCORES	=> 'Comment review scores',
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
