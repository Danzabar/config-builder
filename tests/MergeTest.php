<?php

use Danzabar\Config\Merger;

/**
 * Test case for the merger class
 *
 * @package Config
 * @subpackage Tests
 * @author Dan Cox
 */
class MergeTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Test setting custom options
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_options()
	{
		$merge = new Merger(
			Array('directory' => __DIR__.'/Files/', 'file' => 'test.json'),
			Array('directory' => __DIR__.'/Files/', 'file' => 'test.yml'),
			Array(
			'saveAsMaster' => false,
			'saveFormat'   => 'yml'			
		));
	
		$this->assertEquals(Array(
			'saveAsMaster' => false,
			'saveFormat'   => 'yml',
			'autoWrite'    => true,
			'baseDirectory'=> NULL,
			'overwrite'	   => false
		), $merge->getOptions());
	}

	/**
	 * Test setting global directory
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_BaseDirectory()
	{
		$merge = new Merger('test.json', 'test.yml', Array('baseDirectory' => __DIR__.'/Files/'));

		$master = $merge->getMaster();
		$slave = $merge->getSlave();

		$this->assertEquals(__DIR__.'/Files/', $master->getDirectory());
		$this->assertEquals(__DIR__.'/Files/', $slave->getDirectory());
	}


} // END class MergeTest extends \PHPUnit_Framework_TestCase
