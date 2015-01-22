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

	/**
	 * Loading and saving a basic yml file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_SavingBasicFile()
	{
		$file = new ConfigFile($this->fs);
		
		$this->fs->shouldReceive('exists')->andReturn(TRUE);

		$file->load(dirname(__DIR__) . '/Data/TestFiles/test.yml');

		$file->params()->test = 'value';

		$this->fs->shouldReceive('dumpFile')->with(dirname(__DIR__) . '/Data/TestFiles/test.yml', "test: value\n");

		$file->save();
	}

	/**
	 * Deletion tests
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_loadAndDelete()
	{
		$file = new ConfigFile($this->fs);

		$this->fs->shouldReceive('exists')->andReturn(TRUE);

		$file->load(dirname(__DIR__) . '/Data/TestFiles/test.yml');

		$this->fs->shouldReceive('remove')->with(dirname(__DIR__) . '/Data/TestFiles/test.yml');

		$file->delete();
	}

	/**
	 * Test the refresh function by loading a real file, changing params and hitting the refresh param
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_refresh()
	{
		$file = new ConfigFile();

		$file->load(dirname(__DIR__) . '/Data/TestFiles/test.yml');

		$this->assertTrue(isset($file->params()->test));
		$this->assertEquals(Array('this', 'is', 'a', 'test'), $file->params()->test);

		$file->params()->test = 'foo';

		$file->refresh();

		$this->assertTrue(isset($file->params()->test));
		$this->assertEquals(Array('this', 'is', 'a', 'test'), $file->params()->test);
			
	}

	/**
	 * Test converting a yml to json file. 
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_conversionToFormat()
	{
		$file = new ConfigFile($this->fs);
		
		$this->fs->shouldReceive('exists')->andReturn(TRUE);
		$this->fs->shouldReceive('dumpFile')->with(dirname(__DIR__) . '/Data/TestFiles/test.yml', "test: value\n");		

		$file->load(dirname(__DIR__) . '/Data/TestFiles/test.json');

		$file->saveAs('yml');
	}

	/**
	 * Test the renaming file function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_renameFile()
	{
		$file = new ConfigFile($this->fs);

		$this->fs->shouldReceive('exists')->andReturn(TRUE);
		$this->fs->shouldReceive('dumpFile')->with(dirname(__DIR__) . '/Data/TestFiles/newName.yml', "{ }");

		$file->load(dirname(__DIR__) . '/Data/TestFiles/test.yml');

		$file->params()->clear();
		$file->rename('newName');
		$file->save();
	}

} // END class ConfigFileTest extends \PHPUnit_Framework_TestCase
