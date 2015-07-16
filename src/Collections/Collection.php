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
	 * @param \Symfony\Component\Finder\Finder $finder
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

		$this->registerStandardObjects();
	}

	/**
	 * Registers the extension map and sets the finder to look for files
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function registerStandardObjects()
	{
		$this->extensionMap = new ExtensionMap();
		$this->extensions = $this->extensionMap->getRegisteredExtensionNames();
		$this->finder->files();
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

		$this->filter($filter);
	}

	/**
	 * Fetches all files in the given directory that have registered extensions set
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function all()
	{	
		return $this->fetch();
	}

	/**
	 * Filters down the finder by specifing a second directory
	 *
	 * @param String $directory
	 * @return Collection
	 * @author Dan Cox
	 */
	public function whereIn($directory)
	{	
		$this->finder->in($directory);

		return $this;
	}

	/**
	 * Excludes the directory using the finder
	 *
	 * @param String $directory
	 * @return Collection
	 * @author Dan Cox
	 */
	public function excludeDir($directory)
	{
		$this->finder->exclude($directory);

		return $this;
	}

	/**
	 * Excludes the name from the search
	 *
	 * @param String $keyword
	 * @return Collection
	 * @author Dan Cox
	 */
	public function exclude($keyword)
	{
		$this->finder->notName($keyword);

		return $this;
	}

	/**
	 * Adds custom filter to the finder
	 *
	 * @param Callable $filterCallback
	 * @return Collection
	 * @author Dan Cox
	 */
	public function filter($filterCallback)
	{
		$this->finder->filter($filterCallback);

		return $this;
	}

	/**
	 * Fetches results of current instance of the finder
	 *
	 * @return CollectionResults
	 * @author Dan Cox
	 */
	public function fetch()
	{
		$this->filterByExtension();

		$results = Array();

		foreach ($this->finder as $file)
		{
			$config = new ConfigFile($this->fs, $this->fileInfo, $this->extracter);
			$config->load($file->getRealPath());
			$results[] = $config;
		}

		$this->finder = new Finder();

		return new CollectionResults($results);
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

		// Set the finder to use this directory as well
		$this->finder->in($directory);

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

	/**
	 * Returns the instanced finder
	 *
	 * @return \Symfony\Component\Finder\Finder
	 * @author Dan Cox
	 */
	public function finder()
	{	
		return $this->finder;
	}

} // END class Collection
