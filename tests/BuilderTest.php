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

} // END class BuilderTest extends \PHPUnit_Framework_TestCase
