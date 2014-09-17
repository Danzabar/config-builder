<?php

use Mockery as m;
use Danzabar\Config\Builder;


/**
 * Tests methds in the builder class
 *
 * @package Config
 * @subpackage Test
 * @author Dan Cox
 */
class BuilderTest extends \PHPUnit_Framework_TestCase
{
	
	/**
	 * Mock of symfony file system class
	 *
	 * @var Object
	 */
	protected $fs;
	
	/**
	 * An instance of the builder class
	 *
	 * @var Object
	 */
	protected $builder;

	/**
	 * set up this test environment
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		$this->mock = m::mock('FileSystem');
		
		$this->mock->shouldReceive('exists')->andReturn(TRUE);

		$this->builder = new Builder('test/dir/', '0775', $this->mock);
	}
	
	/**
	 * Tear down test environment
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function tearDown()
	{
		m::close();
	}

	/**
	 * Test the array building function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_cleanseMissingData()
	{
		$arr = array(
			'file1' => array('extension' => 'json'),
			'file2' => array(),
			'file3'
		);

		$this->builder->cleanse($arr);
		
		$files = $this->builder->getFiles();
		
		$this->assertTrue( isset($files['file3']['extension']) );
	}

	/**
	 * Test the make functions most basic task
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_makeConfigs()
	{
		$this->mock->shouldReceive('dumpFile')->with('test/dir/test.json', '[]')->once();

		$this->builder->make('test');

		$this->assertEmpty($this->builder->getErrors());
	}
	
	/**
	 * Add files in bulk
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_makeBulkConfig()
	{
		$this->mock->shouldReceive('dumpFile')->times(3);

		$files = array('test1', 'test2', 'test3');

		$this->builder->make($files);

		// Assert that the file arr has 3 entries
		$this->assertEquals( count($this->builder->getFiles()), 3);

		// Assert theres no errors.
		$this->assertEmpty($this->builder->getErrors());
	}
	
	/**
	 * Test throwing and capturing exceptions
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_Exception()
	{
		$this->mock->shouldReceive('dumpFile')->andThrow( new Exception('test exception') );

		$this->builder->make('file');
		
		$errors = $this->builder->getErrors();

		// Errors should have an entry
		$this->assertNotEmpty($errors);

		$this->assertEquals('test exception', $errors[0]['message']);	
	}

} // END class BuilderTest extends \PHPUnit_Framework_TestCase
