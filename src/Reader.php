<?php namespace Danzabar\Config;

use Symfony\Component\Filesystem\Filesystem;
use Danzabar\Config\Delegator;
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
	 * An instance of the specific translator class
	 *
	 * @var Object
	 */
	protected $translator;

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
	 * The raw file output
	 *
	 * @var Mixed
	 */
	protected $raw;	

	/**
	 * An instance of symfony file system
	 *
	 * @var Object
	 */
	protected $fs;

	/**
	 * Stored translation of file
	 *
	 * @var Mixed
	 */
	protected $translated;

	/**
	 * The file extension
	 *
	 * @var string
	 */
	protected $extension;

	/**
	 * Read the file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($directory, $fs = NULL)
	{
		$this->directory = $directory;

		$this->fs = (!is_null($fs) ? $fs : new FileSystem);
	
		// If the directory doesnt exist, throw and exception
		if(!$this->fs->exists($directory))
		{
			throw new Exception\NotFoundException("The $directory directory could not be found", 0, NULL, $directory);	
		}
	}

	/**
	 * Returns the raw data
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function getRaw()
	{
		return $this->raw;
	}

} // END class Reader

