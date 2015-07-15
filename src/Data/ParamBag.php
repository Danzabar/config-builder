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
	 * An associative array used to backup the params state
	 *
	 * @var Array
	 */
	protected $backup;

	/**
	 * Flag to state whether a backup has been made
	 *
	 * @var Boolean
	 */
	protected $hasBackup = FALSE;

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
	 * Loads an array to replace its full param array
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function load(Array $data = Array())
	{
		$this->params = $data;
	}

	/**
	 * Return the desired var inside the Params array
	 *
	 * @return void
	 * @author Dan Cox
	 *
	 * @throws Exceptions\AccessToInvalidKey
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
	 * Removes a value from the param bag
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __unset($key)
	{
		unset($this->params[$key]);
	}

	/**
	 * Removes everything from the bag
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function clear()
	{
		$this->params = Array();
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

	/**
	 * Merge an array into the param bag
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function merge($arr)
	{
		$this->params = array_merge($this->params, $arr);
	}

	/**
	 * Saves the state of the param bag so it can be reverted
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function backup()
	{
		$this->backup = $this->params;

		$this->hasBackup = TRUE;
	}

	/**
	 * Uses the backup array to revert the params array
	 *
	 * @return void
	 * @author Dan Cox
	 *
	 * @throws Exceptions\NoValidBackup
	 */
	public function rollback()
	{
		if($this->hasBackup)
		{
			$this->params = $this->backup;

		} else
		{
			throw new Exceptions\NoValidBackup($this->params);
		}	
	}
} // END class ParamBag
