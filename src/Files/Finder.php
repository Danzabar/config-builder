<?php namespace Danzabar\Config\Files;

use Symfony\Component\Finder\Finder as SymFinder;


/**
 * Used to find files and return relevent details to ConfigFile class
 *
 * @package Config
 * @subpackage Files
 * @author Dan Cox
 */
class Finder
{
	/**
	 * An instance of the symfony finder class
	 *
	 * @var Object
	 */
	protected $find;

	/**
	 * Set up depedencies
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($finder = NULL)
	{
		$this->find = (!is_null($finder) ? $finder : new SymFinder);
	}

	/**
	 * Returns instance of the Symfony finder class
	 *
	 * @return SymFinder
	 * @author Dan Cox
	 */
	public function getInstance()
	{
		return $this->find;
	}
	
} // END class Finder
