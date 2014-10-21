<?php

use Danzabar\Config\Collection;
use Danzabar\Config\Collections\CollectionFactory;

/**
 * Test Case Class for the Collection and factory classes
 *
 * @package Config
 * @subpackage Tests
 * @author Dan Cox
 */
class CollectionTest extends \PHPUnit_Framework_Testcase
{
	
	/**
	 * Set up the test environment
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		Collection::setDirectory(__DIR__.'/Files/');
	}

	/**
	 * Basic test to make sure everything is set as expected with directories and files.
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_Basic()
	{
		$collection = new Collection('testFile.json');

		$this->assertEquals(__DIR__.'/Files/', $collection->getDirectory());
		$this->assertEquals(NULL, $collection->getReader());
		$this->assertInstanceOf('Danzabar\Config\Writer', $collection->getWriter());
		$this->assertInstanceOf('Danzabar\Config\Collections\CollectionAttributes', $collection->getAttributes());
	}

	/**
	 * Test similar to above but with existing file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_exists()
	{
		$collection = new Collection('test.json');

		$this->assertEquals(__DIR__.'/Files/', $collection->getDirectory());
		$this->assertInstanceOf('Danzabar\Config\Reader', $collection->getReader());
		$this->assertInstanceOf('Danzabar\Config\Writer', $collection->getWriter());
		$this->assertInstanceOf('Danzabar\Config\Collections\CollectionAttributes', $collection->getAttributes());
	}

	/**
	 * Testing the setter and getter functionality
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_getSet()
	{
		$collection = new Collection('tester.json');

		$collection->testVar = 'testval';

		$this->assertEquals('testval', $collection->testVar);
	}




} // END class CollectionTest extends \PHPUnit_Framework_Testcase
