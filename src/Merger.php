<?php namespace Danzabar\Config;

use Danzabar\Config\Reader;
use Danzabar\Config\Delegator;


/**
 * Merger class merges two config files
 *
 * @package Config
 * @subpackage Merger
 * @author Dan Cox
 */
class Merger
{
	/**
	 * The master file, if a value is in here, it will override
	 *
	 * @var Reader
	 */
	protected $master;

	/**
	 * The slave file, values in here will only be included if they dont exist in the master
	 *
	 * @var Reader
	 */
	protected $slave;

	/**
	 * Options that govern the merge action
	 *
	 * @var Array
	 */
	protected $options;

	/**
	 * Load the files
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($masterFile, $slaveFile, Array $options = Array())
	{
		$this->sortOptions($options);
		$this->setUpReader('master', $masterFile);
		$this->setUpReader('slave', $slaveFile);
	}

	/**
	 * Sets up the reader class for the files, using the options set
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUpReader($key, $details)
	{
		if(!is_null($this->options['baseDirectory']) && !is_array($details))
		{
			$this->$key = new Reader($this->options['baseDirectory']);
			$this->$key->read($details);
		} else
		{
			$this->$key = new Reader($details['directory']);
			$this->$key->read($details['file']);
		}
	}

	/**
	 * Replaces custom options with defaults
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function sortOptions(Array $options)
	{
		$defaults = [
			'saveAsMaster'		=> true,  // This option determines whether we should save in the master files format
			'saveFormat'		=> NULL,  // If you select false for previous, you must select a format
			'autoWrite'			=> true,  // Auto write the merge
			'baseDirectory'		=> NULL,  // Set a base directory, that all files use
			'overwrite'			=> false  // Overwrite the master file
		];	
		
		$this->options = array_replace($defaults, $options);
	}

	/**
	 * Returns the options Array
	 *
	 * @return Array
	 * @author Dan Cox
	 */
	public function getOptions()
	{
		return $this->options;
	}

	/**
	 * Returns the master
	 *
	 * @return Reader
	 * @author Dan Cox
	 */
	public function getMaster()
	{
		return $this->master;
	}

	/**
	 * Returns the slave
	 *
	 * @return Reader
	 * @author Dan Cox
	 */
	public function getSlave()
	{
		return $this->slave;
	}



} // END class Merger
