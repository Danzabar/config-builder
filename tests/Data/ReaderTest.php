<?php

use Danzabar\Config\Data\Reader,
	\Mockery as m;

/**
 * Test case for the reader class
 *
 * @package Config
 * @subpackage Tests\Data
 * @author Dan Cox
 */
class ReaderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Mockery of the file system
	 *
	 * @var Object
	 */
	protected $fs;

	/**
	 * Set up test env
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		$this->fs = m::mock('Filesystem');
	}

	/**
	 * Tear down test env
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function tearDown()
	{
		m::close();
	}

	/**
	 * Test loading a file and reading with thrown exception from missing file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_thrownExceptionMissingFile()
	{
		$this->setExpectedException('Danzabar\Config\Exceptions\FileNotExists');
		
		$reader = new Reader();	
		$reader->read('test');
	}

	/**
	 * Test the process with an actual file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_withFile()
	{
		$reader = new Reader();
		$reader->read(__DIR__ . '/TestFiles/test.yml');

		$this->assertContains('this', $reader->getData());
		$this->assertContains('is', $reader->getData());
		$this->assertContains('a', $reader->getData());
		$this->assertContains('test', $reader->getData());
		$this->assertEquals(__DIR__ . '/TestFiles/test.yml', $reader->getFile());
	}

	/**
	 * Test as default the reader has the right classes
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_instancesOf()
	{
		$reader = new Reader;

		$this->assertInstanceOf('Symfony\Component\Filesystem\Filesystem', $reader->getFs());
	}

} // END class ReaderTest extends \PHPUnit_Framework_TestCase

