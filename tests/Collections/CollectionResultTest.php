<?php

use Danzabar\Config\Collections\CollectionResults;

/**
 * Test Case for the Collection Results class
 *
 * @package Config
 * @subpackage Test
 * @author Dan Cox
 */
class CollectionResultTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Testing array access methods
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_arrayAccess()
	{
		$res = new CollectionResults(['foo' => 'bar' ]);
		$res['test'] = 'value';
		$res[] = 'zim';

		$this->assertTrue(isset($res['foo']));
		$this->assertEquals('bar', $res['foo']);
		$this->assertEquals('value', $res['test']);
		$this->assertEquals('zim', $res[0]);

		unset($res['foo']);

		$this->assertFalse(isset($res['foo']));
		$this->assertTrue($res->valid('test'));
	}

	/**
	 * Test iteration methods
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_iterator()
	{
		$res = new CollectionResults([1 => 1, 2 => 2, 3 => 3]);

		$this->assertEquals(3, $res->count());
		$this->assertEquals(1, $res->current());
		$this->assertEquals(1, $res->key());
		$this->assertEquals(2, $res->next());

		$res->rewind();
	}


} // END class CollectionResultTest extends \PHPUnit_Framework_TestCase
