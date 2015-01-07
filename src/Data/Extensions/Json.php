<?php namespace Danzabar\Config\Data\Extensions;

use Danzabar\Config\Data\Extensions\ExtensionInterface;

/**
 * Translates php arrays to json in a dynamic environment
 *
 * @package Config
 * @subpackage Translator
 * @author Dan Cox
 */
class Json Implements ExtensionInterface
{
	
	/**
	 * An array containing the raw data
	 *
	 * @var array|json
	 */
	protected $data;
	

	/**
	 * Loads the data.
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function load($data)
	{
		$this->data = $data;
	}

	/**
	 * Returns json for the php array given
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function toNative()
	{
		return json_encode( $this->data, JSON_PRETTY_PRINT);
	}

	/**
	 * Validates the php array to make sure it wont return a NULL value
	 *
	 * @return boolean
	 * @author Dan Cox
	 */
	public function validateArray()
	{
		return (is_array($this->data));
	}
	
	/**
	 * Translates json back into php array format
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function toArray()
	{
		return json_decode( $this->data , TRUE );
	}
	
	/**
	 * Validates a json string loaded.
	 *
	 * @return boolean
	 * @author Dan Cox
	 */
	public function validate()
	{
		json_decode($this->data);
		
		return (json_last_error() == JSON_ERROR_NONE);
	}

} // END class Json
