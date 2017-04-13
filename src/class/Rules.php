<?php
namespace WFV;
defined( 'ABSPATH' ) or die();

/**
 *
 *
 * @since 0.8.0
 */
class Rules implements Validation {

  use Accessor;
  use Mutator;

  /**
   * __construct
   *
   * @since 0.8.0
   *
   */
  function __construct() {

  }

  /**
   * Push rules onto an instance of Valitron
   *
   * @since 0.7.0
   * @param object $valitron Instance of Valitron\Validator
   * @param object (optional) $messages Instance of WFV_Messages
   */
  public function load( &$valitron, $messages = null ) {

    // loop the field
    foreach( $this as $field => $rules ) {

      // loop this field rules - a field can have many rules
      foreach( $rules as $rule ) {
        if( $this->is_custom( $rule ) ) {
          $this->add( $rule, $valitron );
        }

        // check if this field/rule has a custom error message
        if( $messages->exist( $field, $rule ) ) {
          $message = $messages->$field;
          $valitron->rule( $rule, $field )->message( $message[ $rule ] );
        } else { // use defaults
          $valitron->rule( $rule, $field );
        }
      }
    }
  }

  /**
   * Add custom rule to Valitron\Validator
   * Trigger callback function for this custom rule
   *
   * @since 0.7.1
   * @param string $rule
   * @param object $valitron Instance of Valitron\Validator
   * @access private
   */
  private function add( $rule, $valitron ) {
    $valitron::addRule( $rule, function($field, $value, array $params, array $fields ) use ( $rule ) {
      $rule = explode( ':', $rule );
      $callback = 'wfv__'. $rule[1];
      // TODO: throw exception if no callback, or warning?
      return ( function_exists( $callback ) ) ? $callback( $value ) : false;
    });
  }

  /**
   * Check if rule is custom
   *
   * @since 0.7.0
   * @param string $rule
   * @access private
   *
   * @return bool
   */
  private function is_custom( $rule ) {
    return ( false !== strpos( $rule, 'custom:' ) ) ? true: false;
  }
}
