<?php namespace Danzabar\Config;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Danzabar\Config\Writer;
use Danzabar\Config\Exception;


/**
 * Reader for files
 *
 * @package Config
 * @subpackage Reader
 * @author Dan Cox
 */
class Reader
{
	/**
	 * The directory string
	 *
	 * @var string
	 */
	protected $directory;
	
	/**
	 * The file we are reading, ie "test.json"
	 *
	 * @var string
	 */
	protected $file;
	
	/**
	 * An instance of symfony file system
	 *
	 * @var Object
	 */
	protected $fs;

	/**
	 * The file extension
	 *
	 * @var string
	 */
	protected $extension;
	
	/**
	 * An instance of the writer class
	 *
	 * @var Object
	 */
	protected $writer;

	/**
	 * The raw output of the file loaded
	 *
	 * @var Mixed
	 */
	protected $raw;

	/**
	 * An instance of the finder class
	 *
	 * @var Object
	 */
	protected $finder;

	/**
	 * Read the file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($directory, $fs = NULL, $finder = NULL)
	{
		$this->directory = $directory;

		$this->fs = (!is_null($fs) ? $fs : new FileSystem);

		$this->finder = (!is_null($finder) ? $finder : new Finder);
	
		// If the directory doesnt exist, throw and exception
		if(!$this->fs->exists($directory))
		{
			throw new Exception\NotFoundException("The $directory directory could not be found", 0, NULL, $directory);	
		}
	}

		
	/**
	 * Opens the file specified
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function read($file)
	{
		$files = $this->finder->files()->in($this->directory)->name($file);

		// We are looping through this but it will only
		// ever return one result
		foreach($files as $finder)
		{
			$this->raw = $finder->getContents();
			$this->extension = $finder->getExtension();

			$this->writer = new Writer($finder->getExtension(), $finder->getContents()); 
			$this->writer->addFile($this->directory.$file);
						
			$this->translated = $this->writer->getData(); 
		}	
	}	

	/**
	 * Gets the writer object created for the current file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function getWriter()
	{
		return $this->writer;		
	}

	/**
	 * Gets the translated copy of file contents
	 *
	 * @return Array
	 * @author Dan Cox
	 */
	public function getTranslated()
	{
		return $this->translated;
	}

	/**
	 * Returns the raw output from a file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function getRaw()
	{
		return $this->raw;
	}

	/**
	 * Returns the file extension
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function getExtension()
	{
		return $this->extension;
	}

} // END class Reader

