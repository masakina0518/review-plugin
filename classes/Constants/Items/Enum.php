<?php

namespace ReviewPlugin\Constants\Items;

abstract class Enum
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
	 * @param string $clazz
	 * @param mixed $id
	 * @return void
	 */
	public static function factory( string $clazz_name, $id ): Enum {
		$ref = new \ReflectionClass( $clazz_name );
		$consts = $ref->getConstants();
		if ( !in_array( $id, $consts, true ) ) {
			throw new \InvalidArgumentException;
		}
		if( isset( self::$instances[$clazz_name.$id] ) ) {
			return self::$instances[$clazz_name.$id];
		}
		return self::$instances[$clazz_name.$id] = new $clazz_name( $id );
	}

	/**
	 * getEnums
	 *
	 * @return array
	 */
	public static function getEnums(): array {
		$clazz_name = get_called_class();
		$ref = new \ReflectionClass( $clazz_name );
		$contains = $ref->getConstants();
		$enums = [];
		foreach ( $contains as $val ) {
			$enums[] = self::factory( $clazz_name, $val );
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
     * equals
     *
     * @param mixed $id
     * @return bool
     */
	public function equals( $id ): bool {
		$clazz_name = get_class( $this );
		if ( !isset( self::$instances[$clazz_name.$id]) ) {
			self::factory( $clazz_name, $id );
		}
		if ( self::$instances[$clazz_name.$id]->getId() === $this->getId() ) {
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
