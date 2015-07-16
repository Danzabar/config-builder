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
	 * @var \Symfony\Component\Filesystem\Filesystem
	 */
	protected $fs;

	/**
	 * An instance of the file info class
	 *
	 * @var \Danzabar\Config\Files\FileInfo
	 */
	protected $info;

	/**
	 * Extracter object
	 *
	 * @var \Danzabar\Config\Data\Extracter
	 */
	protected $extracter;

	/**
	 * Instance of the param bag
	 *
	 * @var \Danzabar\Config\Data\ParamBag
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
	 * @param \Symfony\Component\Filesystem\Filesystem $fs
	 * @param \Danzabar\Config\Files\FileInfo $fileInfo
	 * @param \Danzabar\Config\Data\Extracter $extracter
	 * @author Dan Cox
	 */
	public function __construct($fs = NULL, $fileInfo = NULL, $extracter = NULL)
	{
		$this->fs = (!is_null($fs) ? $fs : new Filesystem);
		$this->info = (!is_null($fileInfo) ? $fileInfo : new FileInfo);
		$this->extracter = (!is_null($extracter) ? $extracter : new Extracter);
	} 

	/**
	 * Attempts loading a file, if its not there, it create its.
	 *
	 * @param String $file
	 * @return ConfigFile
	 * @author Dan Cox
	 */
	public function init($file)
	{
		try {
			
			$this->load($file);

		} catch (Exceptions\FileNotExists $e) {

			$this->create($file);
		}
	}

	/**
	 * Creates the file
	 *
	 * @param String $file
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
	 * @param String $file
	 * @return ConfigFile
	 * @author Dan Cox
	 *
	 * @throws Exceptions\FileNotExists
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
	 * Re-loads the file after saves
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function refresh()
	{
		$this->load($this->file);
	}

	/**
	 * Save as a different extension
	 *
	 * @param String $extension
	 * @return void
	 * @author Dan Cox
	 */
	public function saveAs($extension = NULL)
	{
		$extension = (!is_null($extension) ? $extension : $this->extension);

		$converter = $this->extracter->converter();
		$converter->setExtension($extension);
		$data = $converter->toNative($this->params);
	
		// We need to rename the file's extension
		$this->rename(NULL, $extension);

		$this->fs->dumpFile($this->file, $data);	
	}

	/**
	 * Renames a file or changes files extension
	 *
	 * @param String $file
	 * @param String $extension
	 * @return void
	 * @author Dan Cox
	 */
	public function rename($file = NULL, $extension = NULL)
	{
		$target = (!is_null($file) ? $this->filename : $this->extension);
		$replacement = (!is_null($file) ? $file .'.'. $this->extension : $extension);

		$this->file = str_replace($target, $replacement, $this->file);
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
	 * Deletes this config file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function delete()
	{
		$this->fs->remove($this->file);
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
