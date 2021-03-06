<?php namespace Danzabar\Config\Data;

use Danzabar\Config\Data\Extensions\YamlTranslator as Yaml,
	Danzabar\Config\Data\Extensions\Json;


/**
 * Maps file extensions to extension translation classes
 *
 * @package Config
 * @subpackage Data
 * @author Dan Cox
 */
class ExtensionMap
{
	/**
	 * An associative array of extensions => classes
	 *
	 * @var Array
	 */
	protected static $bindings;

	/**
	 * Add the default extensions
	 *
	 * @author Dan Cox
	 */
	public function __construct()
	{
		$this->add('json', new Json);
		$this->add('yml', new Yaml);
	}

	/**
	 * Adds a new class instance binding
	 *
	 * @param String $extension
	 * @param ExtensionInterface $classInstance 
	 * @return void
	 * @author Dan Cox
	 */
	public function add($extension, $classInstance)
	{
		static::$bindings[$extension] = $classInstance;
	}

	/**
	 * Returns the key values for all registered extensions
	 *
	 * @return Array
	 * @author Dan Cox
	 */
	public function getRegisteredExtensionNames()
	{
		return array_keys(static::$bindings);
	}

	/**
	 * Checks if we have a binding for the given extension
	 *
	 * @param String $extension
	 * @return Boolean
	 * @author Dan Cox
	 */
	public function has($extension)
	{
		return array_key_exists($extension, static::$bindings);
	}

	/**
	 * Get one or all bindings
	 *
	 * @param String $extension
	 * @return Mixed
	 * @author Dan Cox
	 */
	public function get($extension = NULL)
	{
		if(is_null($extension))
		{
			return static::$bindings;
		}

		return static::$bindings[$extension];
	}
	
} // END class ExtensionMap
