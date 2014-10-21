<?php namespace Danzabar\Config\Collections;

/**
 * The class that contains and interacts with all the data from the files
 *
 * @package Config
 * @subpackage Collections
 * @author Dan Cox
 */
class CollectionAttributes
{

	/**
	 * The raw data from the file.
	 *
	 * @var Array
	 */
	protected $rawData;


	/**
	 * Loads the data and processes it for further use
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($data = NULL)
	{
		$this->rawData = $data;
	}

	/**
	 * Gets a variable by key
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function get($key)
	{
		if(array_key_exists($key, $this->rawData))
		{
			return $this->rawData[$key];
		}
	}

	/**
	 * Sets a variable by key
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function set($key, $value)
	{
		$this->rawData[$key] = $value;
	}

} // END class CollectionAttributes
