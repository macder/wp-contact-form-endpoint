<?php
namespace WFV;
defined( 'ABSPATH' ) or die();

/**
 *
 *
 * @since 0.8.0
 */
class Validator extends Form implements Validation {

  /**
   * Error message bag
   *
   * @since 0.6.1
   * @since 0.7.3 WFV_Errors instance
   * @access protected
   * @var class $errors Instance of WFV_Errors.
   */
  protected $errors;

  /**
   * Error message overrides
   *
   * @since 0.4.0
   * @since 0.7.0 WFV_Messages instance
   * @access protected
   * @var class $messages Instance of WFV_Messages.
   */
  protected $messages;

  /**
   * Validation rules
   *
   * @since 0.1.0
   * @since 0.7.0 WFV_Rules instance
   * @access protected
   * @var class $rules Instance of WFV_Rules.
   */
  protected $rules;

  use Accessor;
  use Mutator;

  /**
   * __construct
   *
   * @since 0.8.0
   * @param array $form
   *
   */
  function __construct( $action, Rules $rules, Input $input = null ) {
    $properties = array(
      'action' => $action,
      'rules' => $rules,
      'input' => $input,
      'token' => wp_create_nonce( $action ),
    );
    $this->set( $properties );
  }

  /**
   * Check if input action is for this instance.
   * Dies if nonce invalid.
   *
   * @since 0.8.0
   *
   * @return bool True if $this->action is $input->action and nonce is valid.
   */
  public function is_safe( ) {
    if( $this->has_request_action() ) {
      $safe = ( $this->is_legal( $this->input->action ) ) ? true : false;
      $this->check_nonce();
    }
    return ( $safe ) ? true : false;
  }

  /**
   *
   * @param
   * @since 0.8.0
   *
   */
  public function rules( $field = null ) {
    return $this->rules->get( $field );
  }

  /**
   * Do the validation
   *
   * @since 0.2.0
   * @since 0.6.0 Public access
   */
  public function validate() {
    $v = $this->create();

    if ( $v->validate() ) {
      do_action( $this->action, $this );
    } else {
      // errors = $v->errors();
      // $this->errors->set( $errors );
    }
  }

  /**
   * Verify the nonce
   * Prevents CSFR exploits
   *
   * @since 0.2.2
   * @since 0.8.0 no params
   * @access protected
   */
  protected function check_nonce() {
    $nonce = $_REQUEST[ $this->action.'_token' ];
    if ( ! wp_verify_nonce( $nonce, $this->action ) ) {
      die( 'invalid token' );
    }
  }

  /**
   * Create an instance of Valitron\Validator with our rules / messages
   * Assign to $valitron property
   *
   * @since 0.2.0
   * @param array $form Form configuration array
   * @access protected
   */
  private function create() {
    $input = $this->input->get_array();

    $valitron = new \Valitron\Validator( $input );
    // print_r($valitron);

    $this->rules->load( $valitron );
    return $valitron;

    // void in abyss...
  }

  /**
   * Check if $this->input has action property
   *
   * @since 0.8.0
   * @access private
   *
   * @return bool
   */
  private function has_request_action() {
    return ( $this->input->has('action') ) ? true : false;
  }

  /**
   * Safety method.
   * Verifies if the input action matches action on this instance.
   * Very unlikely to get false, unless sneaky things happening...
   *
   * @since 0.8.0
   * @param string $action String to compare against $this->action.
   * @access private
   *
   * @return bool
   */
  private function is_legal( $action ) {
    return ( $action === $this->action ) ? true : false;
  }
}