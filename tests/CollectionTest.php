<?php

use Danzabar\Config\Collection;
use Danzabar\Config\Collections\CollectionFactory;

// Require the Collection TEST Class
require_once(__DIR__ . '/Collections/TestCollection.php');

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
		$collection = new Collection('test.json', __DIR__.'/Files/');

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

	/**
	 * Test getting an attribute that doesnt exist
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_getNotFound()
	{
		$collection = new Collection('tester.json');

		$this->assertNull($collection->fakevar);
	}

	/**
	 * Create a new file with the collection class alone
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_buildNewCollectionFile()
	{
		$data = array('test' => '', 'value' => '');
		
		$collection = new Collection('newfile.json');

		$collection->test = '';
		$collection->value = '';
		$saveData = $collection->save(TRUE);

		$this->assertEquals($data, $saveData);
	}

	/**
	 * Test extending a class from the collection facade to make an easier to use class for a file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_extension()
	{
		$test = new TestCollection();
		$test->var1 = 'test';
		$test->var2 = 'test2';
		
		$saveData = $test->save(TRUE);

		$this->assertEquals(__DIR__.'/Collections/Files/', $test->getDirectory());	
		$this->assertEquals(Array('var1' => 'test', 'var2' => 'test2'), $saveData);
	}

} // END class CollectionTest extends \PHPUnit_Framework_Testcase
