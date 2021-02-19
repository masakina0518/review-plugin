<?php
namespace ReviewPlugin\Constants\Items;

use ReviewPlugin\Constants\Items\Abstract_Enum;

/**
 * Design
 *
 * Design values
 */
class Design extends Abstract_Enum {

    const MINIMALIST	= 1;
    const BOLD			= 2;
    const MODERN		= 3;
	const MODERN_B 		= 4;
	const CLEAN 		= 5;
	const MINIMALIST_B	= 6;

    private static $NAME = [
        self::MINIMALIST	=> 'MINIMALIST',
        self::BOLD			=> 'BOLD',
        self::MODERN		=> 'MODERN',
        self::MODERN_B 		=> 'MODERN B',
        self::CLEAN 		=> 'CLEAN',
        self::MINIMALIST_B 	=> 'MINIMALIST B',
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
