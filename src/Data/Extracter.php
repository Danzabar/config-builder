<?php namespace Danzabar\Config\Data;

use Danzabar\Config\Data\Converter,
	Danzabar\Config\Data\Reader;


/**
 * Extracts data from config files and handles their conversion
 *
 * @package Config
 * @subpackage Data
 * @author Dan Cox
 */
class Extracter
{
	/**
	 * Instance of the converter class
	 *
	 * @var Object
	 */
	protected $converter;

	/**
	 * Instance of the reader class
	 *
	 * @var Object
	 */
	protected $reader;

	/**
	 * The current filename
	 *
	 * @var string
	 */
	protected $file;

	/**
	 * The current extension
	 *
	 * @var string
	 */
	protected $extension;

	
	/**
	 * Load dependencies
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($converter = NULL, $reader = NULL)
	{
		$this->converter = (!is_null($converter) ? $converter : new Converter);
		$this->reader = (!is_null($reader) ? $reader : new Reader);
	}

	/**
	 * Load the file details
	 *
	 * @return Extracter
	 * @author Dan Cox
	 */
	public function load($file, $extension = 'json')
	{
		$this->file = $file;
		$this->extension = $extension;

		return $this;
	}

	/**
	 * Extracts the raw data from the file for conversion
	 *
	 * @return Extracter
	 * @author Dan Cox
	 */
	public function extract()
	{
		$this->reader->read($this->file);

		$this->converter->process($this->extension, $this->reader->getData());
	}

	/**
	 * Returns the param bag created by the converter
	 *
	 * @return ParamBag
	 * @author Dan Cox
	 */
	public function params()
	{	
		return $this->converter->getParamBag();
	}

	/**
	 * Returns the converter
	 *
	 * @return Converter
	 * @author Dan Cox
	 */
	public function converter()
	{
		return $this->converter;
	}

} // END class Extracter
