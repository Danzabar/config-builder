<?php

use Danzabar\Config\Files\ConfigFile;

/**
 * The test case for the Config file class
 *
 * @package Config
 * @subpackage Tests\Files
 * @author Dan Cox
 */
class ConfigFileTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Test that the correct vars are injected
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_correctInjection()
	{
		$file = new ConfigFile;

		$this->assertInstanceOf('Danzabar\Config\Files\Finder', $file->getFinder());
		$this->assertInstanceOf('Symfony\Component\FileSystem\FileSystem', $file->getFs());
		$this->assertInstanceOf('Symfony\Component\Finder\Finder', $file->getFinder()->getInstance());
	}

} // END class ConfigFileTest extends \PHPUnit_Framework_TestCase
