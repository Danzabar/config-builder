<?php namespace Danzabar\Config\Data\Extensions;

/**
 * Interface for extensions
 *
 * @package Config
 * @author Dan Cox
 */
interface ExtensionInterface
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
	 * @return String
	 * @author Dan Cox
	 */
	public function toNative();


	/**
	 * Translates native format back to an Array
	 *
	 * @return Array
	 * @author Dan Cox
	 */
	public function toArray();
	
	
	/**
	 * Validates the native format
	 *
	 * @return Boolean
	 * @author Dan Cox
	 */
	public function validateArray();
	
}
