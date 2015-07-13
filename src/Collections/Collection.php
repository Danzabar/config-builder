<?php namespace Danzabar\Config\Collections;

use Symfony\Component\Finder\Finder,
	Symfony\Component\Filesystem\Filesystem,
	Danzabar\Config\Data\ExtensionMap,
	Danzabar\Config\Files\FileInfo,
	Danzabar\Config\Files\ConfigFile,
	Danzabar\Config\Data\Extracter;


/**
 * Collection class allows for multiple configuration files and query like structure
 *
 * @package Config
 * @subpackage Collections
 * @author Dan Cox
 */
class Collection
{

	/**
	 * Instance of the finder class
	 *
	 * @var \Symfony\Component\Finder\Finder
	 */
	protected $finder;

	/**
	 * Instance of the filesystem
	 *
	 * @var \Symfony\Component\Filesystem\Filesystem
	 */
	protected $fs;

	/**
	 * Instance of the file info class
	 *
	 * @var \Danzabar\Config\Files\FileInfo
	 */
	protected $fileInfo;

	/**
	 * Instance of the extracter class
	 *
	 * @var \Danzabar\Config\Data\Extracter
	 */
	protected $extracter;

	/**
	 * Directory to search in as a string
	 *
	 * @var String
	 */
	protected $directory;

	/**
	 * Instance of the extension map class
	 *
	 * @var \Danzabar\Config\Data\ExtensionMap
	 */
	protected $extensionMap;

	/**
	 * An array of registered extensions
	 *
	 * @var Array
	 */
	protected $extensions;	

	/**
	 * Set up class dependencies
	 *
	 * @param \Syfmony\Component\Finder\Finder $finder
	 * @param \Symfony\Component\Filesystem\Filesystem $fs
	 * @param \Danzabar\Config\Files\FileInfo $fileInfo
	 * @param \Danzabar\Config\Data\Extracter $extracter
	 * @author Dan Cox
	 */
	public function __construct($finder = NULL, $fs = NULL, $fileInfo = NULL, $extracter = NULL)
	{
		$this->finder = (!is_null($finder) ? $finder : new Finder);
		$this->fs = (!is_null($fs) ? $fs : new Filesystem);
		$this->fileInfo = (!is_null($fileInfo) ? $fileInfo : new FileInfo);
		$this->extracter = (!is_null($extracter) ? $extracter : new Extracter);

		$this->extensionMap = new ExtensionMap();
		$this->extensions = $this->extensionMap->getRegisteredExtensionNames();

	}

	/**
	 * Filters file results by their extension
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function filterByExtension()
	{
		// The call back that filters files through the finder
		$filter = function (\SplFileInfo $file) {
			
			return in_array($file->getExtension(), $this->extensions);
		};

		$this->finder->filter($filter);
	}

	/**
	 * Fetches all files in the given directory that have registered extensions set
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function all()
	{	
		$this->finder->files()->in($this->directory);

		$this->filter();
	}

	/**
	 * Sets the directory value
	 *
	 * @param String $directory
	 * @return Collection
	 * @author Dan Cox
	 */
	public function setDirectory($directory)
	{
		$this->directory = $directory;

		return $this;
	}

	/**
	 * Returns the directory value
	 *
	 * @return String
	 * @author Dan Cox
	 */
	public function getDirectory()
	{
		return $this->directory;
	}


} // END class Collection
