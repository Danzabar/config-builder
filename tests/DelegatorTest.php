<?php

use Danzabar\Config\Delegator;


/**
 * Test case for delegator class
 *
 * @package Config
 * @subpackage TestCase
 * @author Dan Cox
 */
class DelegatorTest extends \PHPUnit_Framework_TestCase
{
	
	/**
	 * Test the ability to load classes based on extension
	 *
	 * @return void
	 * @author Dan Cox	
	 */
	public function test_delegationJson()
	{
		$class = Delegator::getByExtension('json');
		
		$this->assertInstanceOf('Danzabar\Config\Translators\Json', $class);
	}
	
	/**
	 * Test the ability to load the XML class through delegation
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_delegationXml()
	{
		$xml = Delegator::getByExtension('xml');

		$this->assertInstanceOf('Danzabar\Config\Translators\Xml', $xml);
	}

	/**
	 * Test the Yaml Delegation
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_delegationYaml()
	{
		$yaml = Delegator::getByExtension('yml');

		$this->assertInstanceOf('Danzabar\Config\Translators\YamlTranslator', $yaml);
	}

	/**
	 * Add a new delegee and call it
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_newAddition()
	{
		Delegator::addExtension('php', Array());
		
		$php = Delegator::getByExtension('php');

		$this->assertTrue( is_array($php) );
	}

	/**
	 * Test the failure of the delegation class
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_fail()
	{	
		$this->setExpectedException('\Danzabar\Config\Exception\InvalidTranslatorException');

		$fail = Delegator::getByExtension('superfail');
	}

} // END class DelegatorTest extends \PHPUnit_Framework_TestCase
