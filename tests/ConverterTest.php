<?php

use Danzabar\Config\Converter;
use Danzabar\Config\Delegator;
use Danzabar\Config\Reader;
use \Mockery as m;


/**
 * The testcase class for the Converter class
 *
 * @package Config
 * @subpackage Tests
 * @author Dan Cox
 */
class ConverterTest extends \PHPUnit_Framework_TestCase
{
	
	/**
	 * The mock class of the file system
	 *
	 * @var object
	 */
	protected $fs;
	
	/**
	 * Setup the basic environment
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		$this->fs = m::mock('FileSystem')->shouldIgnoreMissing();

		$this->fs->shouldReceive('exists')->andReturn('true');
	}
	
	/**
	 * Tear down environment
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function tearDown()
	{
		m::close();
	}		

	/**
	 * Testing the basic usaged
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_BasicUsage()
	{
		$converter = new Converter(__DIR__.'/Files/test.xml', 'json', $this->fs);
		
	  	$this->assertEquals('json', $converter->getToExtension());
		$this->assertEquals('xml', $converter->getFromExtension());
	}
	
	/**
	 * Test the full conversion checking that our data remains integeral
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_fullXML2JSONConvert()
	{
		// For this test we are going to convert xml to json
		$converter = new Converter(__DIR__.'/Files/test.xml', 'json', $this->fs);
		
		$converter->convertFile();

		// Check the translator
		$this->assertInstanceOf('Danzabar\Config\Translators\Json', $converter->getTranslator());

		#$toArray = Delegator::getByExtension('json');
		#$toArray->load($converter->getDump());
		
		#$toXml = Delegator::getByExtension('xml');
		#$toXml->load($toArray->translate());

		#$this->assertEquals(file_get_contents(__DIR__.'/Files/test.xml'), $toXml->translateNative());
			
	}

} // END class ConverterTest extends \PHPUnit_Framework_TestCase
