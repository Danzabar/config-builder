<?php

use Danzabar\Config\Writer;
use Danzabar\Config\Delegator;
use Danzabar\Config\Reader;
use \Mockery as m;



/**
 * Test case for the writer class
 *
 * @package Config
 * @subpackage Test
 * @author Dan Cox
 */
class WriterTest extends \PHPUnit_Framework_TestCase
{
	
	/**
	 * Mock instance of the file system class
	 *
	 * @var object
	 */
	protected $fs;
	
	/**
	 * Setup environment for testing
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		$this->fs = m::mock('FileSystem');	
	}

	/**
	 * Remove test environment
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function tearDown()
	{
		m::close();
	}
	
	/**
	 * Simple test to make sure it can delegate correctly
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_useDelegate()
	{
		$writer = new Writer('json', Array());
	
		$this->assertInstanceOf('Danzabar\Config\Translators\Json', $writer->getTranslator());
	}

	/**
	 * Test the loading and conversion of native data
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_conversion()
	{
		$writer = new Writer('json', '{"valid":"json"}');

		$this->assertEquals($writer->getData(), Array('valid' => 'json'));
	}

	/**
	 * Test that the dump returns false when its not a valid translation
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_dumpFail()
	{
		$this->setExpectedException('Danzabar\Config\Exception\InvalidContentTypeException');

		$writer = new Writer('json', '{"we":"error",;}');
	}	

	/**
	 * Test the append function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_append()
	{
		$writer = new Writer('json', '{"valid":"json"}');
	
		$writer->append(array('more' => 'value'));

		$this->assertEquals($writer->getData(), Array('more' => 'value', 'valid' => 'json'));
	}

	/**
	 * Test the prepend function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_prepend()
	{
		$writer = new Writer('json', '{"valid":"json"}');
		
		$writer->prepend(array('more' => 'value'));

		$this->assertEquals($writer->getData(), Array('valid' => 'json', 'more' => 'value'));
	}

	/**
	 * Test the replace function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_replace()
	{
		$writer = new Writer('json');
		
		$writer->replace('level', 'pass', Array('multi' => array('level', 'array'), 'test2' => 'level'));

		$test = $writer->getData();

		$this->assertTrue( !in_array('level', $test) );
		$this->assertTrue( !in_array('level', $test['multi']) );
	}

	/**
	 * Test thw write to file function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_writeToFile()
	{
		$json = '{"test":"json"}';
		$writer = new Writer('json', $json, $this->fs);

		$comparison = Delegator::getByExtension('json');
		$comparison->load(array('test' => 'json'));

		$this->fs->shouldReceive('exists')->with('/test/location/file.json')->andReturn(TRUE);
		$this->fs->shouldReceive('dumpFile')->with('/test/location/file.json', $comparison->translate());

		$writer->addFile('/test/location/file.json');
		
		$writer->toFile();	
	}
	
	/**
	 * Test the writer function given from the reader
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_writerFromReader()
	{
		$reader = new Reader(__DIR__.'/Files/');

		$reader->read('test.json');
		$writer = $reader->getWriter();

		$this->assertEquals(__DIR__.'/Files/test.json', $writer->getFileLocation());
		$this->assertEquals($reader->getTranslated(), $writer->getData());
	}

} // END class WriterTest extends \PHPUnit_Framework_TestCase
