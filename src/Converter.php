<?php namespace Danzabar\Config;

use Danzabar\Config\Exception;
use Danzabar\Config\Reader;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Convert class converts files into other file types
 *
 * @package Config
 * @subpackage Converter
 * @author Dan Cox
 */
class Converter
{
	/**
	 * The file location we are converting from
	 *
	 * @var string
	 */
	protected $file;
	
	/**
	 * The extension we are starting from
	 *
	 * @var string
	 */
	protected $fromExtension;

	/**
	 * The desired file extension to convert to
	 *
	 * @var string
	 */
	protected $toExtension;

	/**
	 * The output from the conversion
	 *
	 * @var string
	 */
	protected $dump;

	/**
	 * An instance of the reader class
	 *
	 * @var Object
	 */
	protected $reader;

	/**
	 * An instance of the filesystem class
	 *
	 * @var Object
	 */
	protected $fs;

	/**
	 * The raw translation from the chosen file
	 *
	 * @var Array
	 */
	protected $raw;

	/**
	 * An instance of translator class
	 *
	 * @var Object
	 */
	protected $translator;

	/**
	 * Load the file string, check the file exists
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($file, $desiredExtension, $fs = NULL)
	{
		$this->file = $file;
		$this->fromExtension = $this->getPathInfo('extension');
		$this->toExtension = $desiredExtension;
		$this->fs = (!is_null($fs) ? $fs : new FileSystem);

		if(!$this->fs->exists($this->file))
		{
			throw new Exception\NotFoundException("The file $file could not be found", 0, NULL, $file);	
		}
	
		$this->reader = new Reader($this->getPathInfo('dirname').'/');
		$this->reader->read($this->getPathInfo('basename'));

		$this->raw = $this->reader->getTranslated();
	}

	/**
	 * This function deals with the translations and such, ive seperated it so i can isolate it in tests
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function process()
	{	
		$this->translator = Delegator::getByExtension($this->toExtension);
		
		$this->translator->load($this->raw);

		$this->dump = $this->translator->translate();
	}

	/**
	 * Convert the file to the new extension specified	
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function convertFile($fileName = NULL)
	{
		$this->process();

		$filename = (!is_null($fileName) ? $fileName.'.'.$this->toExtension : str_replace($this->fromExtension, $this->toExtension, $this->getPathInfo('basename')));	
		
		$this->fs->dumpFile($this->getPathInfo('dirname').'/'.$filename, $this->dump);
	}

	/**
	 * Returns the translator instance we made
	 *
	 * @return Object
	 * @author Dan Cox
	 */
	public function getTranslator()
	{
		return $this->translator;
	}

	/**
	 * Return the raw translated output
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function getRawOutput()
	{
		return $this->raw;
	}

	/**
	 * Returns the output after the conversion, mostly for testing purposes
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function getDump()
	{
		return $this->dump;
	}

	/**
	 * Returns the extension we started from
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function getFromExtension()
	{
		return $this->fromExtension;
	}

	/**
	 * Returns the extension we are converting to
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function getToExtension()
	{
		return $this->toExtension;
	}
	
	/**
	 * Gets the extension of the current file
	 *
	 * @return string
	 * @author Dan Cox
	 */
	public function getPathInfo($key = NULL)
	{
		$info = pathinfo($this->file);
		
		if(!is_null($key) && array_key_exists($key, $info))
		{
			return $info[$key];
		}

		return $info;	
	}


} // END class Converter
