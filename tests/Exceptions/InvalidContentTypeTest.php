<?php

use Danzabar\Config\Writer;


/**
 * Test case for the InvalidContentTypeException class
 *
 * @package Config
 * @subpackage Test
 * @author Dan Cox
 */
class InvalidContentTypeTest extends \PHPUnit_Framework_TestCase
{
	
	/**
	 * Test the firing of the exception
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_exception()
	{
		$this->setExpectedException('Danzabar\Config\Exception\InvalidContentTypeException');

		new Writer('json', 'invalidjson');
	}

	/**
	 * Test the setting and getting of the contents from the exception
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_contents()
	{
		try
		{
			new Writer('json', 'invalidjson');

		} catch (\Exception $e)
		{
			$this->assertEquals($e->getContents(), 'invalidjson');
		}
	}

	/**
	 * Test the setting and getting of the expected Type
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_expectedType()
	{
		try 
		{
			new Writer('json', 'invalidjson');

		} catch (\Exception $e) 
		{
			$this->assertEquals($e->getExpectedDataType(), 'json');
		}
	}

} // END class InvalidContentTypeTest extends \PHPUnit_Framework_TestCase
