<?php
namespace WFV;
defined( 'ABSPATH' ) || die();

use WFV\Collection\MessageCollection;
use WFV\Contract\ValidateInterface;

/**
 * Validates field/rule pairs using provided strategy classes
 *
 * @since 0.11.0
 */
class Validator {

	/**
	 * Container for error messages for rule/field pairs
	 * Only contains messages for validations that failed
	 *
	 * @since 0.11.0
	 * @access protected
	 * @var array
	 */
	protected $errors = [];

	/**
	 *
	 *
	 * @since 0.11.0
	 * @access protected
	 * @var MessageCollection
	 */
	protected $messages;

	/**
	 *
	 *
	 * @since 0.11.0
	 *
	 * @param
	 */
	public function __construct( MessageCollection $messages ) {
		$this->messages = $messages;
	}

	/**
	 * Returns the array of error messages
	 *
	 * @since 0.11.0
	 *
	 * @return array
	 */
	public function errors() {
		return $this->errors;
	}

	/**
	 * Did the full validation cycle pass or fail?
	 *
	 * @since 0.11.0
	 *
	 * @return bool
	 */
	public function is_valid() {
		return empty( $this->errors );
	}

	/**
	 * Validate a single input using provided rule (strategy)
	 *
	 * @since 0.11.0
	 *
	 * @param ValidateInterface $rule
	 * @param string $field
	 * @param string|array $value
	 * @param bool $optional
	 * @param array (optional) $params
	 * @return self
	 */
	public function validate( ValidateInterface $rule, $field, $value, $optional, $params = false ) {
		$params[] = ( $params ) ? $field : false;
		$valid = $rule->validate( $value, $optional, $params );
		if( !$valid ){
			$this->add_error( $field, $rule->template() );
		}
		return $this;
	}

	/**
	 * Add a single error msg for a field's rule if it failed validating
	 *
	 * @since 0.11.0
	 * @access protected
	 *
	 * @param string $field
	 * @param array $template
	 */
	protected function add_error( $field, array $template ) {
		$message = ( $this->messages->has( $field ) )
			? $this->messages->get_msg( $field, $template['name'] )
			: $template['message'];
		$this->errors[ $field ][ $template['name'] ] = $message;
	}
}
