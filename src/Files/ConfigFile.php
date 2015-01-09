<?php namespace Danzabar\Config\Files;

use Symfony\Component\Filesystem\Filesystem,
	Danzabar\Config\Files\FileInfo;


/**
 * The config file class is the basis of this library
 *
 * @package Config
 * @subpackage Files
 * @author Dan Cox
 */
class ConfigFile
{
	/**
	 * Instance of the file system class
	 *
	 * @var Object
	 */
	protected $fs;

	/**
	 * An instance of the file info class
	 *
	 * @var Object
	 */
	protected $info;

	/**
	 * The file extension
	 *
	 * @var string
	 */
	protected $extension;

	/**
	 * The file name
	 *
	 * @var string
	 */
	protected $filename;

	/**
	 * The file directory
	 *
	 * @var string
	 */
	protected $directory;

	/**
	 * Set up dependencies
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($fs = NULL, $fileInfo = NULL)
	{
		$this->fs = (!is_null($fs) ? $fs : new Filesystem);
		$this->info = (!is_null($fileInfo) ? $fileInfo : new FileInfo);
	} 

	/**
	 * Creates the file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function create($file)
	{
		$this->fs->dumpFile($file, '');

		return $this->load($file);
	}

	/**
	 * Loads the file and its details
	 *
	 * @return ConfigFile
	 * @author Dan Cox
	 */
	public function load($file)
	{
		// If the file doesnt exist yet, create it
		if(!$this->fs->exists($file))
		{
			return $this->create($file);
		}

		$info->load($file);
		$this->extension = $info->extension;
		$this->directory = $info->directory;
		$this->filename = $info->filename;

		return $this;
	}

	/**
	 * Returns the extension
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function getExtension()
	{
		return $this->extension;
	}

	/**
	 * Returns the filename
	 *
	 * @return String
	 * @author Dan Cox
	 */
	public function getFileName()
	{
		return $this->filename;
	}

	/**
	 * Returns the file system instance
	 *
	 * @return FileSystem
	 * @author Dan Cox
	 */
	public function getFs()
	{
		return $this->fs;
	}

	
} // END class ConfigFile
