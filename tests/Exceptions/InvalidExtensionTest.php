<?php

use Danzabar\Config\Exceptions\InvalidExtension;

/**
 * Test case for the invalid extension exception
 *
 * @package Config
 * @subpackage Tests\Exceptions
 * @author Dan Cox
 */
class InvalidExtensionTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Fire the exception
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_fire()
	{
		try {
			throw new InvalidExtension('test');
		} catch(\Exception $e) {
			
			$this->assertEquals('test', $e->getExtension());
		}
	}

} // END class InvalidExtensionTest extends \PHPUnit_Framework_TestCase
