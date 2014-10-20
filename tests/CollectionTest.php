<?php

use Danzabar\Config\Collection;
use Danzabar\Config\Collections\CollectionFactory;

/**
 * Test Case Class for the Collection and factory classes
 *
 * @package Config
 * @subpackage Tests
 * @author Dan Cox
 */
class CollectionTest extends \PHPUnit_Framework_Testcase
{
	

	/**
	 * Basic test to make sure everything is set as expected with directories and files.
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_Basic()
	{
		$collection = new Collection('testFile.json', __DIR__);
	}


} // END class CollectionTest extends \PHPUnit_Framework_Testcase
