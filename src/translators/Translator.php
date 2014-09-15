<?php namespace Danzabar\Config\Translators;

/**
 * Interface for translators
 *
 * @package Config
 * @author Dan Cox
 */
interface Translator
{
	
	/**
	 * Loads the mixed data
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function load($data);

	/**
	 * Validates the array thats passed to it.
	 *
	 * @return Boolean
	 * @author Dan Cox
	 */
	public function validate();
	

	/**
	 * Translates the data into the native format.
	 *
	 * @return Mixed
	 * @author Dan Cox
	 */
	public function translate();


	/**
	 * Translates native format back to an Array
	 *
	 * @return Array
	 * @author Dan Cox
	 */
	public function translateNative();
	
	
	/**
	 * Validates the native format
	 *
	 * @return Boolean
	 * @author Dan Cox
	 */
	public function validateNative();
	
}
