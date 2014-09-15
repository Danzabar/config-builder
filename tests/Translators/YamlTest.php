<?php require_once dirname(__DIR__) . '/environment.php';

use Danzabar\Config\Translators\YamlTranslator as YAML;

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

		$this->yaml = new YAML($this->data);
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
		$this->assertTrue( $this->yaml->validate() );

		// The result is valid yaml
		$check = new YAML( $this->yaml->translate() );

		$this->assertTrue( $check->validateNative() );
	}

	/**
	 * Test converting the Yaml output back to Php Array
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_translateNative()
	{
		$php = new YAML($this->yaml->translate());

		// It is valid yaml
		$this->assertTrue( $php->validateNative() );
			
		$this->assertEquals( $this->data, $php->translateNative() );
	}

} // END class YAMLTest extends \PHPUnit_Framework_TestCase

