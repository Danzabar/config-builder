<?php namespace Danzabar\Config\Translators;

/**
 * Translates php arrays to json in a dynamic environment
 *
 * @package Config
 * @subpackage Translator
 * @author Dan Cox
 */
class Json Implements Translator
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
	public function translate()
	{
		return json_encode( $this->data, JSON_PRETTY_PRINT);
	}

	/**
	 * Validates the php array to make sure it wont return a NULL value
	 *
	 * @return boolean
	 * @author Dan Cox
	 */
	public function validate()
	{
		return (is_array($this->data));
	}
	
	/**
	 * Translates json back into php array format
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function translateNative()
	{
		return json_decode( $this->data , TRUE );
	}
	
	/**
	 * Validates a json string loaded.
	 *
	 * @return boolean
	 * @author Dan Cox
	 */
	public function validateNative()
	{
		json_decode($this->data);
		
		return (json_last_error() == JSON_ERROR_NONE);
	}

} // END class Json
