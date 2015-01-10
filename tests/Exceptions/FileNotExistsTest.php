<?php

use Danzabar\Config\Exceptions\FileNotExists;

/**
 * Test Case for the file not exists exception class
 *
 * @package Config
 * @subpackage Tests\Exceptions
 * @author Dan Cox
 */
class FileNotExistsTest extends \PHPUnit_Framework_TestCase
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
			throw new FileNotExists('test.yml');
		} catch (\Exception $e) {

			$this->assertEquals('test.yml', $e->getFilename());
		}
	}

} // END class FileNotExistsTest extends \PHPUnit_Framework_TestCase
