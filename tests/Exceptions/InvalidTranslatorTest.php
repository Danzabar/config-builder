<?php

use Danzabar\Config\Delegator;


/**
 * Test case for the invalid translator test exception
 *
 * @package Config
 * @subpackage Tests
 * @author Dan Cox
 */
class InvalidTranslatorTest extends \PHPUnit_Framework_TestCase
{
	
	/**
	 * Test the firing of the exception
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_exception()
	{
		$this->setExpectedException('\Danzabar\Config\Exception\InvalidTranslatorException');

		// Make a request to a fake extension to the delegator
		// This SHOULD fire the exception we want
		Delegator::getByExtension('fake');
	}
	
	/**
	 * Test the other functions of the exception
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_exceptionVars()
	{
		try 
		{
			Delegator::getByExtension('fake');	

		} catch (\Exception $e) {
			
			$this->assertEquals('fake', $e->getExtension());	
		}
	}

} // END class InvalidTranslatorTest extends \PHPUnit_Framework_TestCase
