<?php namespace Danzabar\Config\Data;

use Danzabar\Config\Data\ExtensionMap,
	Danzabar\Config\Data\ParamBag,
	Danzabar\Config\Exceptions;


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
	 * The raw data given
	 *
	 * @var Mixed
	 */
	protected $data;

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

	/**
	 * Loads an extension class to convert the data to an array and pass it back as a param bag
	 *
	 * @return ParamBag
	 * @author Dan Cox
	 */
	public function process($extension, $data = '')
	{
		$this->extension = $extension;
		$this->data = $data;

		if($this->extensionMap->has($extension))
		{
			$ext = $this->extensionMap->get($extension);
			$arr = $ext->load($data)->toArray();

			$this->paramBag = new ParamBag($arr);

			return true;
		}

		throw new Exceptions\InvalidExtension($extension);
	}

	/**
	 * Returns the instance of the param bag
	 *
	 * @return ParamBag
	 * @author Dan Cox
	 */
	public function getParamBag()
	{
		return $this->paramBag;
	}

	/**
	 * Returns the instance of the extension map
	 *
	 * @return ExtensionMap
	 * @author Dan Cox
	 */
	public function getExtensionMap()
	{
		return $this->extensionMap;
	}

	/**
	 * Returns the extension
	 *
	 * @return String
	 * @author Dan Cox
	 */
	public function getExtension()
	{
		return $this->extension;
	}

	/**
	 * Returns the raw data loaded
	 *
	 * @return Mixed
	 * @author Dan Cox
	 */
	public function getData()
	{
		return $this->data;
	}
	
} // END class Converter
