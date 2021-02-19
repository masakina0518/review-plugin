<?php

namespace ReviewPlugin\Constants\Items;

abstract class Abstract_Enum
{
    /**
	 * @var array Enum Instances
	 */
    protected static $instances = [];

    /**
	 * @var array id
	 */
    protected $id;

    /**
     * __construct
     *
     * @param mixed $id
     */
    public function __construct( $id ) {
        $this->id = $id;
    }

    /**
     * factory
     *
     * @param string $class
     * @param mixed $id
     * @return void
     */
    public static function factory( string $class, $id ): Abstract_Enum {
        $ref = new \ReflectionClass( $class );
        $consts = $ref->getConstants();
        if ( !in_array( $id, $consts, true ) ) {
            throw new \InvalidArgumentException;
        }
        if( isset( self::$instances[$class.$id] ) ) {
            return self::$instances[$class.$id];
        }
        return self::$instances[$class.$id] = new $class( $id );
    }

	/**
	 * getEnums
	 *
	 * @return array
	 */
	public static function getEnums(): array {
		$class_name = get_called_class();
        $ref = new \ReflectionClass( $class_name );
		$contains = $ref->getConstants();
		$enums = [];
		foreach ( $contains as $val ) {
			$enums[] = self::factory( $class_name, $val );
		}
		return $enums;
	}

    /**
     * getId
     *
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * equeals
     *
     * @param mixed $id
     * @return bool
     */
    public function equeals( $id ): bool {
        if ( !isset( self::$instances[$id]) ) {
            return false;
        }
        if ( self::$instances[$id]->getId() === $this->getId() ) {
            return true;
        }
        return false;
    }

	/**
	 * __clone
	 *
	 * @return void
	 */
    public function __clone() {
        throw new \Exception( sprintf( 'Clone is not allowed: %s', get_class( $this ) ) );
    }
}
