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
	 * Test replacing all params with an array after init
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_replaceAllParams()
	{
		$p = new ParamBag(Array('test' => 'value'));

		$p->load(Array('foo' => 'bar'));
		$this->assertEquals(Array('foo' => 'bar'), $p->all());
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

	/**
	 * Test the merge function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_merge()
	{
		$arr = Array('a' => 'b', 'c' => 'd');
		$merge = Array('d' => 'c', 'c' => 'b');

		$p = new ParamBag($arr);
		$p->merge($merge);
		
		$this->assertEquals(Array('a' => 'b', 'c' => 'b', 'd' => 'c'), $p->all());
	}

	/**
	 * Test the clear function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_clear()
	{
		$arr = Array('a' => 'b');

		$p = new ParamBag($arr);

		$p->clear();

		$this->assertEquals(Array(), $p->all());
	}

	/**
	 * Test unsetting value
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_unset()
	{
		$arr = Array('a' => 'b', 'c' => 'd');

		$p = new ParamBag($arr);

		$this->assertEquals('b', $p->a);
	
		unset($p->a);

		$this->assertFalse(isset($p->a));
	}

	/**
	 * Test a working backup
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_backups()
	{
		$array = Array('a' => 'b', 'c' => 'd');

		$p = new ParamBag($array);
		$p->backup();

		$p->c = 'foo';

		$this->assertEquals('foo', $p->c);

		$p->rollback();

		$this->assertEquals('d', $p->c);
	}

	/**
	 * test an invalid backup
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_exceptionOnInvalidBackup()
	{
		$this->setExpectedException('Danzabar\Config\Exceptions\NoValidBackup');
		$p = new ParamBag(Array());

		$p->rollback();
	}

} // END class ParamBagTest extends \PHPUnit_Framework_TestCase
