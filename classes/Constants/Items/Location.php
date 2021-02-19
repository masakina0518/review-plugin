<?php
namespace ReviewPlugin\Constants\Items;

use ReviewPlugin\Constants\Items\Abstract_Enum;

/**
 * Location
 *
 * Location values
 */
class Location extends Abstract_Enum {

    const BOTTOM	= 1;
    const TOP		= 2;
    const TOPBOTTOM	= 3;
	const SHORTCODE = 4;

    private static $NAME = [
        self::BOTTOM	=> 'BOTTOM',
        self::TOP		=> 'TOP',
        self::TOPBOTTOM	=> 'TOP + BOTTOM',
        self::SHORTCODE => 'SHORTCODE',
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
