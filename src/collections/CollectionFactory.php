<?php namespace Danzabar\Config\Collections;

use Danzabar\Config\Collections\CollectionInterface;
use Danzabar\Config\Collections\CollectionAttributes;
use Danzabar\Config\Writer;
use Danzabar\Config\Reader;
use Symfony\Component\Filesystem\Filesystem;


/**
 * Factory class for collections
 *
 * @package Config
 * @subpackage Collections
 * @author Dan Cox
 */
class CollectionFactory implements CollectionInterface
{
	/**
	 * The directory of the files
	 *
	 * @var string
	 */
	protected static $directory;

	/**
	 * The Target file name
	 *
	 * @var string
	 */
	protected $fileName;

	/**
	 * The file format - only for new files
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * An instance of the reader class for this specific file.
	 *
	 * @var Object
	 */
	protected $reader;

	/**
	 * An instance of the writer class for this file.
	 *
	 * @var Object
	 */
	protected $writer;

	/**
	 * Instance of the file system
	 *
	 * @var Object
	 */
	protected $fs;

	/**
	 * An instance of the CollectionAttributes class
	 *
	 * @var Object	
	 */
	protected $attributes;

	/**
	 * Checks the file, and builds relevent reader/writer class for this.
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($extension = 'json')
	{
		$this->fs = new FileSystem;

		if($this->fs->exists(static::$directory.$this->fileName))
		{
			// Existing file, load the writer / reader
			$this->buildReader();
		}	

		$this->buildWriter();
		$this->loadAttributes();
	}

	/**
	 * Return an attribute
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __get($key)
	{
		return $this->attributes->get($key);
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __set($key, $value)
	{
		$this->attributes->set($key, $value);
	}

	/**
	 * Sets up the reader and writer variables
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function buildReader()
	{
		$this->reader = new Reader(static::$directory);
		$this->reader->read($this->fileName);
	}

	/**
	 * Builds the writer class
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function buildWriter($extension = 'json')
	{
		if(!is_null($this->reader))
		{
			$this->writer = $this->reader->getWriter();
		} else
		{
			$this->writer = new Writer($extension);
			$this->writer->addFile(static::$directory.$this->fileName);
		}
	}

	/**
	 * Creates an instance of the CollectionAttribute class and loads data from file if available.
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function loadAttributes()
	{
		$data = Array();

		if(!is_null($this->reader))
		{
			$data = $this->reader->getTranslated();
		}

		$this->attributes = new CollectionAttributes($data);
	}

	/**
	 * Saves the edited / newly created data.
	 * If Mock is TRUE it will return the dump values.
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function save($writer = NULL)
	{
		if($writer)
		{
			$this->writer = $writer;
		}
	
		$this->writer->load($this->attributes->getData());	
		$this->writer->toFile();

		return $this->attributes->getData();
	}

	/**
	 * Returns the writer instance
	 *
	 * @return object
	 * @author Dan Cox
	 */
	public function getWriter()
	{
		return $this->writer;
	}

	/**
	 * Returns the reader instance
	 *
	 * @return object
	 * @author Dan Cox
	 */
	public function getReader()
	{
		return $this->reader;
	}

	/**
	 * Returns the current working directory
	 *
	 * @return string
	 * @author Dan Cox
	 */
	public function getDirectory()
	{
		return static::$directory;
	}

	/**
	 * Return the current instance of the CollectionAttributes class
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}
		
	
} // END class CollectionFactory
