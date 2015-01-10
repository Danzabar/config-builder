<?php 

use Danzabar\Config\Data\Extensions\YamlTranslator as YAML;

/**
 * Tests for the YAML Translator
 *
 * @package Config
 * @subpackage Test
 * @author Dan Cox
 */
class YamlTest extends \PHPUnit_Framework_TestCase
{
	
	/**
	 * The array data
	 *
	 * @var Array
	 */
	protected $data;
	
	/**
	 * An instance of the YAML Translator Class
	 *
	 * @var Object
	 */
	protected $yaml;
	
	/**
	 * Set up the test environment
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		$this->data = array('basic', 'array' => array('multi', 'level'), 'test' => 'test');

		$this->yaml = new YAML();
		$this->yaml->load($this->data);
	}

	/**
	 * Test the basic translate function, do we have a YAML object afterwards?
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_translate()
	{
		// The array is valid
		$this->assertTrue( $this->yaml->validateArray() );

		// The result is valid yaml
		$check = new YAML();
		$check->load( $this->yaml->toNative() );

		$this->assertTrue( $check->validate() );
	}

	/**
	 * Test converting the Yaml output back to Php Array
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_translateNative()
	{
		$php = new YAML();
		$php->load($this->yaml->toNative());

		// It is valid yaml
		$this->assertTrue( $php->validate() );
			
		$this->assertEquals( $this->data, $php->toArray() );
	}

	/**
	 * Tests the fail of the validateNative function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_validateFail()
	{
		$fail = new YAML();
		$fail->load( Array() );

		$this->assertFalse( $fail->validate() );
	}

} // END class YAMLTest extends \PHPUnit_Framework_TestCase

