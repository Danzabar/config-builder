<?php namespace Danzabar\Config\Data;

use Symfony\Component\Finder\Finder,
	Danzabar\Config\Data\Converter;


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
	 * The current filename
	 *
	 * @var string
	 */
	protected $filename;

	/**
	 * The current directory
	 *
	 * @var string
	 */
	protected $directory;

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
	public function __construct($converter = NULL)
	{
		$this->converter = (!is_null($converter) ? $converter : new Converter);
	}

} // END class Extracter
