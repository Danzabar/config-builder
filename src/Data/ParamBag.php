<?php namespace Danzabar\Config\Data;

use Danzabar\Config\Exceptions;


/**
 * The param bag class is used to hold and fetch variables
 *
 * @package Config
 * @subpackage Data
 * @author Dan Cox
 */
class ParamBag
{
	/**
	 * Associative array of parameters
	 *
	 * @var Array
	 */
	protected $params;

	/**
	 * Load the first set of data
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($data = Array())
	{
		$this->params = $data;
	}

	/**
	 * Return the desired var inside the Params array
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __get($key)
	{
		if(array_key_exists($key, $this->params))
		{
			return $this->params[$key];
		}

		throw new Exceptions\AccessToInvalidKey($key);
	}

	/**
	 * Magic isset function
	 *
	 * @return Boolean
	 * @author Dan Cox
	 */
	public function __isset($key)
	{
		return array_key_exists($key, $this->params);
	}

	/**
	 * Magic setter
	 *
	 * @return Void
	 * @author Dan Cox
	 */
	public function __set($key, $value)
	{
		$this->params[$key] = $value;
	}

	/**
	 * Returns the whole bag
	 *
	 * @return Array
	 * @author Dan Cox
	 */
	public function all()
	{
		return $this->params;
	}

	/**
	 * Search and replace function for multi level arrays
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function recursiveReplace($search, $replace)
	{
		$json = json_encode($this->params);

		$json = str_replace($search, $replace, $json);

		$this->params = json_decode($json, TRUE);
	}

} // END class ParamBag
