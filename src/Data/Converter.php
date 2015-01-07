<?php namespace Danzabar\Config\Data;

use Danzabar\Config\Data\ExtensionMap;


/**
 * Converts the native data from a file to an array using various packages
 *
 * @package Config
 * @subpackage Data
 * @author Dan Cox
 */
class Converter
{
	/**
	 * The file extension
	 *
	 * @var string
	 */
	protected $extension;

	/**
	 * Instance of the extension map class
	 *
	 * @var Object
	 */
	protected $extensionMap;

	/**
	 * An instance of the parambag with values
	 *
	 * @var Object
	 */
	protected $paramBag;

	/**
	 * Set up class vars
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($map = NULL)
	{
		$this->extensionMap = (!is_null($map) ? $map : new ExtensionMap);
	}
	
} // END class Converter
