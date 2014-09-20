<?php

use Danzabar\Config\Reader;
use \Mockery as m;


/**
 * Test case for the Reader class
 *
 * @package Config
 * @subpackage Test
 * @author Dan Cox
 */
class ReaderTest extends \PHPUnit_Framework_TestCase
{
	
	/**
	 * An instance of the reader class
	 *
	 * @var Object
	 */
	protected $reader;		

	/**
	 * An instance of the file system class
	 *
	 * @var Object
	 */
	protected $fs;

	/**
	 * an instance of the finder class
	 *
	 * @var Object
	 */
	protected $finder;
	
	/**
	 * Setup the test environment
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		$this->fs = m::mock('FileSystem');
		$this->finder = m::mock('Finder');
		
		// To get an instance of the reader, we can just pass true to exists
		$this->fs->shouldReceive('exists')->with('test/dir')->andReturn(TRUE);

		$this->reader = new Reader('test/dir', $this->fs, $this->finder);
	}

	/**
	 * Test loading a file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_load()
	{
		$this->finder->shouldReceive('files')->andReturn( $this->finder );
		$this->finder->shouldReceive('in')->with('test/dir')->andReturn( $this->finder );
		$this->finder->shouldReceive('getContents')->andReturn('{"json":"test"}');
		$this->finder->shouldReceive('getExtension')->andReturn('json');
		$this->finder->shouldReceive('name')->with('testfile.json')->andReturn( Array( $this->finder ));

		
		$this->reader->read('testfile.json');
	
		$this->assertEquals( $this->reader->getRaw(), '{"json":"test"}' );
		$this->assertEquals( $this->reader->getExtension(), 'json' );
	}

	/**
	 * Test reading a real file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_readJson()
	{
		$reader = new Reader(__DIR__.'/Files/');
		
		$reader->read('test.json');

		$this->assertInstanceOf('Danzabar\Config\Writer', $reader->getWriter());
		$this->assertInstanceOf('Danzabar\Config\Translators\Json', $reader->getWriter()->getTranslator());
		$this->assertTrue( is_array($reader->getTranslated()) );
		$this->assertArrayHasKey( 'test', $reader->getTranslated() );
	}

} // END class ReaderTest extends \PHPUnit_Framework_TestCase
