<?php
namespace WFV\Builder;
defined( 'ABSPATH' ) or die();

use WFV\Contract\BuilderInterface;
use WFV\Component\Errors;
use WFV\Component\Form;
use WFV\Component\Input;
use WFV\Component\Rules;

/**
 *
 *
 * @since 0.10.0
 */
class FormBuilder implements BuilderInterface {

	/**
	 *
	 *
	 * @since 0.10.0
	 * @access private
	 * @var array
	 */
	private $components = array();

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
	 * @var WFV\Component\Form
	 */
	private $form;

	/**
	 *
	 *
	 * @since 0.10.0
	 *
	 * @param string $action
	 * @return WFV\Builder\FormBuilder
	 */
	public function create( $action ) {
		$this->form = new Form( $action, $this->components );
		return $this;
	}

	/**
	 * Return the final Form instance
	 *
	 * @since 0.10.0
	 *
	 * @return WFV\Component\Form
	 */
	public function deliver() {
		return $this->form;
	}

	/**
	 *
	 *
	 * @since 0.10.0
	 *
	 * @return WFV\Builder\FormBuilder
	 */
	public function errors() {
		$this->components['errors'] = new Errors();
		return $this;
	}

	/**
	 *
	 *
	 * @since 0.10.0
	 *
	 * @param string $action
	 * @return WFV\Builder\FormBuilder
	 */
	public function input( $action ) {
		$this->components['input'] = new Input( $action );
		return $this;
	}

	/**
	 *
	 *
	 * @since 0.10.0
	 *
	 * @return WFV\Builder\FormBuilder
	 */
	public function messages() {
		return $this;
	}

	/**
	 *
	 *
	 * @since 0.10.0
	 *
	 * @param array $rules
	 * @return WFV\Builder\FormBuilder
	 */
	public function rules( array $rules ) {
		$this->components['rules'] = new Rules( $rules );
		return $this;
	}
}
