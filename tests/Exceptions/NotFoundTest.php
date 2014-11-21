<?php

use \Mockery as m;
use Danzabar\Config\Reader;
use Danzabar\Config\Exception\NotFoundException;


/**
 * Test case for the exception class NotFound;
 *
 * @package Config
 * @subpackage Test
 * @author Dan Cox
 */
class NotFoundTest extends \PHPUnit_Framework_TestCase
{
	
	/**
	 * An instance of the reader class
	 *
	 * @var Object
	 */
	protected $reader;
	
	/**
	 * An mock of symfony file system
	 *
	 * @var Object
	 */
	protected $fs;


	/**
	 * Setup the test environment
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		$this->fs = m::mock('FileSystem');		
	}

	/**
	 * test the exception
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_exception()
	{
		$this->fs->shouldReceive('exists')->andReturn(false);
			
		$this->setExpectedException('\Danzabar\Config\Exception\NotFoundException', 'The test/dir directory could not be found');

		$this->reader = new Reader('test/dir', $this->fs);
	}

	/**
	 * Test just firing and catching exception
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_fireException()
	{
		$exception = NULL;
		try {

			throw new NotFoundException('', 0, NULL, 'test');

		} catch (\Exception $e) {
			
			$exception = $e;
		}

		$this->assertInstanceOf('\Exception', $exception);
		$this->assertEquals('test', $exception->getPath());
	}

	/**
	 * Test the path getter
	 *
	 * @depends test_exception
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_path()
	{
		$this->fs->shouldReceive('exists')->andReturn('false');

		try
		{
			new Reader('test/dir', $this->fs);
		} catch (\Danzabar\Config\Exception\NotFoundException $e)
		{
			$this->assertEquals('test/dir', $e->getPath());
		}
	}

} // END class NotFoundTest extends \PHPUnit_Framework_TestCase
