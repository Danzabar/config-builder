<?php

use Danzabar\Config\Exceptions\NoValidBackup;

/**
 * Test case for the No Valid Backup exception
 *
 * @package Config
 * @subpackage Tests\Exceptions
 * @author Dan Cox
 */
class NoValidBackupTest extends \PHPUnit_Framework_TestCase
{
	
	/**
	 * Test firing exception
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_fire()
	{
		try {
			throw new NoValidBackup();
		} catch (\Exception $e) {
			$this->assertEquals(Array(), $e->getParams());
		}
	}

} // END class NoValidBackupTest extends \PHPUnit_Framework_TestCase
