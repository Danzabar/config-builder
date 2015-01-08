<?php

use Danzabar\Config\Exceptions\AccessToInvalidKey;

/**
 * Test Case for the invalid key exception class
 *
 * @package Config
 * @subpackage Tests\Exceptions
 * @author Dan Cox
 */
class AccessToInvalidKeyTest extends PHPUnit_Framework_TestCase
{

	/**
	 * Just fire
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_fire()
	{
		try {
			throw new AccessToInvalidKey('test');

		} catch (\Exception $e) {

			$this->assertEquals('test', $e->getAttemptedKey());
		}
	}
} // END class AccessToInvalidKeyTest extends PHPUnit_Framework_TestCase

