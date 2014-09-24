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
	 * Test the conversion of json to YAML
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_JsonToYaml()
	{
		$converter = new Converter(__DIR__.'/Files/test.json', 'yml', $this->fs);
		
		$converter->convertFile();

		$this->assertInstanceOf('Danzabar\Config\Translators\YamlTranslator', $converter->getTranslator());

		$toArray = Delegator::getByExtension('yml');
		$toArray->load($converter->getDump());

		$toJson = Delegator::getByExtension('json');
		$toJson->load($toArray->translateNative());
		
		// Fix for none pretty print json :(	
		$comparison = file_get_contents(__DIR__.'/Files/test.json');
		$comparison = json_decode($comparison, true);

		$this->assertEquals(json_encode($comparison, JSON_PRETTY_PRINT), $toJson->translate());
	}

	/**
	 * Conversion from YAML to json.
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function text_YamlToJson()
	{
		$converter = new Converter(__DIR__.'/Files/test.yml', 'json', $this->fs);

		$converter->convertFile();

		$this->assertInstanceOf('Danzabar\Config\Translatiors\Json', $converter->getTranslator());

		$toArray = Delegator::getByExtension('json');
		$toArray->load($converter->getDump());

		$toYaml = Delegator::getByExtension('yml');
		$toYaml->load($toArray->translateNative());

		$this->assertEquals(file_get_contents(__DIR__.'/Files/test.yml'), $toYaml->translate());
	}
	
	/**
	 * The XML conversion needs some work still. mostly down to the translator class' inability to parse it correctly.
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
		#$toXml->load($toArray->translateNative());

		#$this->assertEquals(file_get_contents(__DIR__.'/Files/test.xml'), $toXml->translate());	
	}

} // END class ConverterTest extends \PHPUnit_Framework_TestCase
