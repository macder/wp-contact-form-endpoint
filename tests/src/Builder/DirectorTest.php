<?php
namespace WFV\Builder;

use WFV\Builder\Director;
use WFV\Builder\FormBuilder;
use WFV\Component\Guard;
use WFV\Component\Form;

class DirectorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Instance of WFV\Builder\Director.
	 *
	 * @access protected
	 * @var WFV\Builder\Director $director
	 */
	protected static $director;

	/**
	 * Instantiate Director
	 *
	 */
	protected function setUp() {
		self::$director = new Director();
	}

	/**
	 * Reset
	 *
	 */
	protected function tearDown() {
		self::$director = null;
	}

	/**
	 * Does describe method return an instance of this director?
	 *
	 */
	public function test_director_describe_return_self_instance() {
		$result = self::$director
			->describe( 'phpunit', 'tested' );
		$this->assertInstanceOf( 'WFV\Builder\Director', $result );
	}

	/**
	 * Does with method return an instance of this director?
	 *
	 */
	public function test_director_with_return_self_instance() {
		$result = self::$director
			->with( 'phpunit', array('lorem', 'ipsum') );
		$this->assertInstanceOf( 'WFV\Builder\Director', $result );
	}

	/**
	 * When using FormBuilder, does compose return an instance of Form?
	 *
	 */
	public function test_director_compose_return_instance_of_form() {
		$builder = new FormBuilder();
		$result = self::$director
			->describe( 'action', 'phpunit' )
			->compose( $builder );

		$this->assertInstanceOf( 'WFV\Component\Form', $result );
	}

	/**
	 * When using GuardBuilder, does compose return an instance of Guard?
	 *
	 */
	public function test_director_compose_return_instance_of_guard() {
		$builder = new GuardBuilder();
		$result = self::$director
			->describe( 'action', 'phpunit' )
			->compose( $builder );
		$this->assertInstanceOf( 'WFV\Component\Guard', $result );
	}
}
