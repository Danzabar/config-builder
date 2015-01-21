<?php

use Danzabar\Config\Data\Converter,
	\Mockery as m;

/**
 * Test case for the converter data class
 *
 * @package Config
 * @subpackage Tests\Data
 * @author Dan Cox
 */
class ConverterTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Mockery of the extension map
	 *
	 * @var Object
	 */
	protected $map;

	/**
	 * Set up test env
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		$this->map = m::mock('ExtensionMap');
	}

	/**
	 * Tear down test env
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function tearDown()
	{
		m::close();
	}

	/**
	 * Test that an exception is fire if we give a fake extension
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_fireExceptionOnIncorrectExtension()
	{
		$this->setExpectedException('Danzabar\Config\Exceptions\InvalidExtension');
		$this->map->shouldReceive('has')
				  ->with('test')
				  ->andReturn(FALSE);

		$converter = new Converter($this->map);

		$converter->setExtension('test');
	}

	/**
	 * Test getting the param bag back from a successfull conversion
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_getParamBag()
	{
		$converter = new Converter($this->map);

		$this->map->shouldReceive('has')->with('json')->andReturn(TRUE);
		$this->map->shouldReceive('get')->andReturn($this->map);
		$this->map->shouldReceive('load')->andReturn($this->map);
		$this->map->shouldReceive('toArray')->andReturn(Array('test' => 'var'));

		$converter->setExtension('json')->process();
		$params = $converter->getParamBag();

		$this->assertInstanceOf('Danzabar\Config\Data\ParamBag', $params);
		$this->assertTrue(isset($params->test));
		$this->assertEquals('var', $params->test);
	}

	/**
	 * Test that the class has the right instances
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_instancesOf()
	{
		$converter = new Converter();
		$converter->setExtension('yml')->process('test');

		$this->assertInstanceOf('Danzabar\Config\Data\ParamBag', $converter->getParamBag());
		$this->assertInstanceOf('Danzabar\Config\Data\ExtensionMap', $converter->getExtensionMap());
		$this->assertEquals('yml', $converter->getExtension());
		$this->assertEquals('test', $converter->getData());
	}

} // END class ConverterTest extends \PHPUnit_Framework_TestCase
