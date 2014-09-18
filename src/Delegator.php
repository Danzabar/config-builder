<?php namespace Danzabar\Config;

use Danzabar\Config\Exception;
use Danzabar\Config\Translators\Json;
use Danzabar\Config\Translators\YamlTranslator;
use Danzabar\Config\Translators\XML;


/**
 * Used to destinguish what translator to use for certain file extensions
 * Will be used to add more translator => extension maps
 *
 * @package Config
 * @subpackage Delegator
 * @author Dan Cox
 */
class Delegator
{
	/**
	 * An array containing a key value map of translators and extensions
	 *
	 * @var Array
	 */
	protected static $extension_map;
	
	/**
	 * Returns a translator based on the extension
	 *
	 * @return Object|Boolean
	 * @author Dan Cox
	 */
	public static function getByExtension($extension)
	{
		if(is_null(static::$extension_map))
		{
			self::buildDefaultExtensionMap();
		}

		if(array_key_exists($extension, static::$extension_map))
		{
			return static::$extension_map[$extension];
		}
		
		throw new Exception\InvalidTranslatorException("The extension provided does not have an assigned translator, extension: $extension", $extension); 
	}

	/**
	 * Adds a new Extension => Translator map,
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public static function addExtension($extension, $classInstance)
	{
		static::$extension_map[$extension] = $classInstance;
	}

	/**
	 * Populates the extension map with the default translators
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public static function buildDefaultExtensionMap()
	{
		static::$extension_map = array(
			'json'		=> new Json(),
			'yml'		=> new YamlTranslator(),
			'xml'		=> new XML()
		);
	}
	
} // END class Delegator
