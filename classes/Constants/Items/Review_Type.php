<?php
namespace ReviewPlugin\Constants\Items;

use ReviewPlugin\Constants\Items\Abstract_Enum;

/**
 * Review_Type
 *
 * Review_Type values
 */
class Review_Type extends Abstract_Enum {

	const EDITOR_REVIEW_VISITOR_RATINGS	= 0;
	const EDITOR_REVIEW					= 1;
	const VISITOR_RATINGS				= 2;
	const VISITOR_COMMENT_REVIEW		= 3;

	private static $NAME = [
		self::EDITOR_REVIEW_VISITOR_RATINGS	=> 'Editor Review + Visitor Ratings',
		self::EDITOR_REVIEW					=> 'Editor Review',
		self::VISITOR_RATINGS				=> 'Visitor Ratings',
		self::VISITOR_COMMENT_REVIEW		=> 'Visitor Comment Reviews',
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
