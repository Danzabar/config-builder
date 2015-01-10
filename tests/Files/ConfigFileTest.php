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
	 * Mockery of the extracter class
	 *
	 * @var Object
	 */
	protected $extracter;

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
		$this->extracter = m::mock('Extracter');
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
		$file = new ConfigFile($this->fs, $this->infoMock, $this->extracter);

		$this->fs->shouldReceive('exists')->andReturn(True);
		$this->fs->shouldReceive('dumpFile');

		$this->infoMock->shouldReceive('load')->andReturn($this->infoMock);
		$this->infoMock->extension = 'yml';
		$this->infoMock->filename = 'test';
		$this->infoMock->directory = '/test/dir';

		$this->extracter->shouldReceive('load')->andReturn($this->extracter);
		$this->extracter->shouldReceive('extract');
		$this->extracter->shouldReceive('params')->andReturn($this->extracter);

		$file->create('test.yml');

		$this->assertEquals('yml', $file->getExtension());
		$this->assertEquals('test', $file->getFilename());
	}

	/**
	 * Test exception thrown when loading a file that doesnt exist
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_exceptionOnLoadingFile()
	{
		$this->setExpectedException('Danzabar\Config\Exceptions\FileNotExists');	

		$file = new ConfigFile($this->fs, $this->infoMock, $this->extracter);

		$this->fs->shouldReceive('exists')->andReturn(FALSE);

		$file->load('test');
	}

	/**
	 * Test loading a real file and getting a parambag back
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_loadRealFileGetRealParams()
	{
		$file = new ConfigFile;
		$file->load(dirname(__DIR__) . '/Data/TestFiles/test.yml');

		$this->assertInstanceOf('Danzabar\Config\Data\ParamBag', $file->params());
		$this->assertTrue(isset($file->params()->test));
		$this->assertTrue(is_array($file->params()->test));

		$file->params()->test = 'value';

		$this->assertEquals('value', $file->params()->test);
	}

} // END class ConfigFileTest extends \PHPUnit_Framework_TestCase
