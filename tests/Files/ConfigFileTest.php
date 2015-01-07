<?php

use Danzabar\Config\Files\ConfigFile,
	\Mockery as m;

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
	 * A mockery class of the info class
	 *
	 * @var Object
	 */
	protected $infoMock;

	/**
	 * A mockery class of the fs class
	 *
	 * @var Object
	 */
	protected $fs;

	/**
	 * Set up mocks
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		$this->infoMock = m::mock('FileInfo');
		$this->fs = m::mock('FileSystem');
	}

	/**
	 * Tear down mocks
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function tearDown()
	{
		m::close();
	}

	/**
	 * Test that the correct vars are injected
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_correctInjection()
	{
		$file = new ConfigFile;

		$this->assertInstanceOf('Symfony\Component\FileSystem\FileSystem', $file->getFs());
	}

	/**
	 * Test creating and loading a file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_CreateAndLoadFile()
	{
		$file = new ConfigFile($this->fs, $this->infoMock);

		$this->fs->shouldReceive('exists')->andReturn(False);
		$this->fs->shouldReceive('dumpFile');

		$this->fs->shouldReceive('exists')->andReturn(True);
		$this->infoMock->shouldReceive('load')->andReturn($this->infoMock);
		$this->infoMock->extension = 'json';
		$this->infoMock->filename = 'test';
		$this->infoMock->directory = '/test/dir';

			
	}

} // END class ConfigFileTest extends \PHPUnit_Framework_TestCase
