<?php namespace Danzabar\Config\Collections;

use Danzabar\Config\Collections\COllectionInterface;
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
	protected $directory;

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
			$this->reader = new Reader(static::$directory);
			$this->reader->read($this->filename);
			$this->writer = $this->reader->getWriter();

		} else 
		{
			// New file, load the writer
			$this->writer = new Writer($extension);	
			$this->writer->addFile(static::$directory.$this->fileName);
		}	
	}

	/**
	 * Returns the writer instance
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function getWriter()
	{
		return $this->writer;
	}

	/**
	 * Returns the reader instance
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function getReader()
	{
		return $this->reader;
	}
		
	
} // END class CollectionFactory
