<?php namespace Danzabar\Config\ORM;


/**
 * Interface for model class
 *
 * @package Config
 * @author Dan Cox
 */
interface ModelInterface
{
	
	/**
	 * Returns the orientation of the model
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function orientation();

	/**
	 * Maps an array into the models attributes
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function map(Array $data);

	/**
	 * Returns a list of attributes held by this model
	 *
	 * @return Object
	 * @author Dan Cox
	 */
	public function getAttributes();


}
