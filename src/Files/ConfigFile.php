<?php namespace Danzabar\Config\Files;

use Symfony\Component\Filesystem\Filesystem,
	Danzabar\Config\Files\FileInfo,
	Danzabar\Config\Data\Extracter,
	Danzabar\Config\Exceptions;


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
	 * Extracter object
	 *
	 * @var Object
	 */
	protected $extracter;

	/**
	 * Instance of the param bag
	 *
	 * @var Object
	 */
	protected $params;

	/**
	 * The original file name string
	 *
	 * @var string
	 */
	protected $file;	

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
	public function __construct($fs = NULL, $fileInfo = NULL, $extracter = NULL)
	{
		$this->fs = (!is_null($fs) ? $fs : new Filesystem);
		$this->info = (!is_null($fileInfo) ? $fileInfo : new FileInfo);
		$this->extracter = (!is_null($extracter) ? $extracter : new Extracter);
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
		if(!$this->fs->exists($file))
		{
			throw new Exceptions\FileNotExists($file);
		}

		$this->file = $file;
		$this->info->load($file);
		$this->extension = $this->info->extension;
		$this->directory = $this->info->directory;
		$this->filename = $this->info->filename;

		$this->extracter->load($file, $this->extension)
						->extract();

		$this->params = $this->extracter->params();
	}
	
	/**
	 * Saves the current params to the file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function save()
	{
		$converter = $this->extracter->converter();
		$data = $converter->toNative($this->params);

		$this->fs->dumpFile($this->file, $data);
	}

	/**
	 * Returns the param bag
	 *
	 * @return ParamBag
	 * @author Dan Cox
	 */
	public function params()
	{
		return $this->params;
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
