<?php

use Danzabar\Config\Data\ParamBag;

/**
 * Test case for the param bag class
 *
 * @package Config
 * @subpackage Tests\Data
 * @author Dan Cox
 */
class ParamBagTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Test the basic function of the param bag
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_getterSetter()
	{
		$p = new ParamBag(Array('test' => 'var', 'value' => 'bar'));

		$this->assertTrue(isset($p->test));
		$this->assertTrue(isset($p->value));

		$this->assertEquals('var', $p->test);
		$this->assertEquals('bar', $p->value);

		$p->test = 'foo';

		$this->assertEquals('foo', $p->test);

		$this->assertEquals(Array('test' => 'foo', 'value' => 'bar'), $p->all());
	}

	/**
	 * Test that an exception is thrown for a wrong key access
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_throwExceptionWithWrongKey()
	{
		$this->setExpectedException('Danzabar\Config\Exceptions\AccessToInvalidKey');

		$p = new ParamBag;
		$p->fake;
	}

	/**
	 * Test the recursive replacement function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_recursiveReplacement()
	{
		$arr = Array(
			'foo'	=> Array('bar' => Array('foo' => Array('foo')))
		);
		$rep = Array('bar' => Array('test' => Array('test')));

		$p = new ParamBag($arr);
		$p->recursiveReplace('foo', 'test');

		$this->assertEquals($rep, $p->test);
	}

} // END class ParamBagTest extends \PHPUnit_Framework_TestCase
