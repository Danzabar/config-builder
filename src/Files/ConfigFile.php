<?php namespace Danzabar\Config\Files;

use Symfony\Component\FileSystem\FileSystem,
	Danzabar\Config\Files\Finder;


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
	 * Instance of the finder class
	 *
	 * @var Object
	 */
	protected $finder;

	/**
	 * Set up dependencies
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($fs = NULL, $finder = NULL)
	{
		$this->fs = (!is_null($fs) ? $fs : new FileSystem);
		$this->finder = (!is_null($finder) ? $finder : new Finder);
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

	/**
	 * Returns the finder instance
	 *
	 * @return Finder
	 * @author Dan Cox
	 */
	public function getFinder()
	{
		return $this->finder;
	}

	
} // END class ConfigFile
