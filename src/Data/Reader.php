<?php namespace Danzabar\Config\Data;

use Symfony\Component\Filesystem\Filesystem,
	Danzabar\Config\Exceptions;

/**
 * Reads from the file. Basic class that allows us to mock file content.
 *
 * @package Config
 * @subpackage Data
 * @author Dan Cox
 */
class Reader
{	
	/**
	 * The Current file
	 *
	 * @var string
	 */
	protected $file;

	/**
	 * Instance of the File System class
	 *
	 * @var Object
	 */
	protected $fs;

	/**
	 * The raw data from the current file
	 *
	 * @var Mixed
	 */
	protected $data;

	/**
	 * Loads a file for reading
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct( $fs = NULL)
	{
		$this->fs = (!is_null($fs) ? $fs : new Filesystem);
	}

	/**
	 * Read from the file
	 *
	 * @return Reader
	 * @author Dan Cox
	 */
	public function read($file)
	{
		$this->file = $file;

		if($this->fs->exists($this->file)) {

			$this->data = file_get_contents($this->file);

			return $this;
		}

		// Throw exception
		throw new Exceptions\FileNotExists($this->file);
	}

	/**
	 * Returns the given file
	 *
	 * @return String
	 * @author Dan Cox
	 */
	public function getFile()
	{
		return $this->file;
	}

	/**
	 * Returns the data taken from file
	 *
	 * @return Mixed
	 * @author Dan Cox
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Returns the instance of the file system class
	 *
	 * @return Filesystem
	 * @author Dan Cox
	 */
	public function getFs()
	{
		return $this->fs;
	}

} // END class Reader
