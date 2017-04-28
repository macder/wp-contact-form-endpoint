<?php
namespace WFV\Builder;
defined( 'ABSPATH' ) or die();

use WFV\Contract\BuilderInterface;

/**
 *
 *
 * @since 0.10.0
 *
 */
class Director {

	/**
	 *
	 *
	 * @since 0.10.0
	 * @access private
	 * @var array
	 */
	private $config = array();

	/**
	 *
	 *
	 * @since 0.10.0
	 * @access private
	 * @var array
	 */
	private $components = array();

	/**
	 * Give an attribute
	 *
	 * @since 0.10.0
	 *
	 * @param string $type
	 * @param string $attribute
	 * @return WFV\Builder\Director
	 */
	public function describe( $type, $attribute ) {
		$this->config[ $type ] = $attribute;
		return $this;
	}

	/**
	 * To bring into existence, an entity
	 *
	 * @since 0.10.0
	 *
	 * @param BuilderInterface $builder
	 * @return class
	 */
	public function produce( BuilderInterface $builder ) {
		$this->integrate( $this->components, $builder );
		return $builder
			->create( $this->config['action'] )
			->deliver();
	}

	/**
	 * Add attributes to concieve an entity.
	 *
	 * @since 0.10.0
	 *
	 * @param string $entity
	 * @param string|array (optional) $attributes
	 * @return WFV\Builder\Director
	 */
	public function compose( $entity, $attributes = null ) {
		$this->components[ $entity ] = $attributes;
		return $this;
	}

	/**
	 * Invokes builder methods to create entities
	 *	for the component under construction.
	 *
	 * @since 0.10.0
	 * @access private
	 *
	 * @param array $components
	 * @param BuilderInterface $builder
	 */
	private function integrate( array $components, BuilderInterface &$builder ) {
		foreach( $components as $entity => $attributes ) {
			$builder->$entity( $attributes );
		}
	}
}
