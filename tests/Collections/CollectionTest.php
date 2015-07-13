<?php

use Danzabar\Config\Collections\Collection,
	\Mockery as m;

/**
 * Test case for the Collection class
 *
 * @package Config
 * @subpackage Tests
 * @author Dan Cox
 */
class CollectionTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Mockery instance of the FileSystem class
	 *
	 * @var \Symfony\Component\Filesystem\Filesystem
	 */
	protected $fs;

	/**
	 * Mockery instance of the FileInfo Class
	 *
	 * @var \Danzabar\Config\Files\FileInfo
	 */
	protected $fileInfo;

	/**
	 * Mockery instance of the extracter class
	 *
	 * @var \Danzabar\Config\Data\Extracter
	 */
	protected $extracter;

	/**
	 * Set up test dependencies
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		$this->fs = m::mock('FileSystem');
		$this->fileInfo = m::mock('FileInfo');
		$this->extracter = m::mock('Extracter');
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
	 * Test getting files from folder in a collection result
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_getFileResultsFromFolder()
	{
		$collection = new Collection();
		$collection->setDirectory(__DIR__ . '/Files/Test1/');

		$results = $collection->all();

		// This should provide us with 2 files
		$this->assertEquals(2, count($results)); 
		$this->assertInstanceOf('Danzabar\Config\Files\ConfigFile', $results[0]);
	}

	/**
	 * Test the filtering functionality
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_filteringFunctionality()
	{
		$collection = new Collection();

		$result1 = $collection->whereIn(__DIR__ . '/Files/Test1/')->exclude('config1*')->fetch();
		$result2 = $collection->whereIn(__DIR__ . '/Files/')->excludeDir('Test1')->fetch(); 
		
		$this->assertEquals(1, count($result1));
		$this->assertEquals(0, count($result2));
	}

} // END class CollectionTest extends \PHPUnit_Framework_TestCase
