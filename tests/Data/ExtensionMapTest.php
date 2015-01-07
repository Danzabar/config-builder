<?php 

use Danzabar\Config\Data\ExtensionMap;

/**
 * Test Case for the extension map class
 *
 * @package Config
 * @subpackage Tests\Data
 * @author Dan Cox
 */
class ExtensionMapTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Instance of the mapper
	 *
	 * @var Object
	 */
	protected $map;

	/**
	 * Setup map
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		$this->map = new ExtensionMap;
	}

	/**
	 * Test that the default extensions are added
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_defaultsAdded()
	{
		$this->assertTrue($this->map->has('json'));
		$this->assertTrue($this->map->has('yml'));
	}

	/**
	 * Test adding an extension
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_addingExtension()
	{
		$this->map->add('test', Array());

		$this->assertTrue($this->map->has('test'));
		$this->assertEquals(Array(), $this->map->get('test'));
	}

	/**
	 * Test the defaults instance of
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_instanceOf()
	{
		$this->assertInstanceOf('Danzabar\Config\Data\Extensions\Json', $this->map->get('json'));
		$this->assertInstanceOf('Danzabar\Config\Data\Extensions\YamlTranslator', $this->map->get('yml'));
	}


} // END class ExtensionMapTest extends \PHPUnit_Framework_TestCase
