<?php namespace Danzabar\Config\Files;

use Danzabar\Config\Files\ConfigFile;

/**
 * The merger class can be used to merge two config files
 *
 * @package Config
 * @subpackage Files
 * @author Dan Cox
 */
class Merger
{
	/**
	 * The master file
	 *
	 * @var Object
	 */
	protected $master;

	/**
	 * The slave file
	 *
	 * @var Object
	 */
	protected $slave;

	/**
	 * Flag to delete the slave file on merge action
	 *
	 * @var Boolean
	 */
	protected $deleteSlaveOnMerge;

	/**
	 * Writes the master file after merging data if set to TRUE
	 *
	 * @var Boolean
	 */
	protected $autoSaveMaster;

	/**
	 * Saves a param bag backup before merging so you can use the rollback method
	 *
	 * @var Boolean
	 */
	protected $saveBackupBeforeMerge;

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($autoSaveMaster = TRUE, $saveBackupBeforeMerge = TRUE, $deleteSlaveOnMerge = FALSE)
	{
		$this->autoSaveMaster = $autoSaveMaster;
		$this->saveBackupBeforeMerge = $saveBackupBeforeMerge;
		$this->deleteSlaveOnMerge = $deleteSlaveOnMerge;
	}

	/**
	 * Loads the master and slave files
	 *
	 * @return Merger
	 * @author Dan Cox
	 */
	public function load(ConfigFile $master, ConfigFile $slave)
	{
		$this->master = $master;
		$this->slave = $slave;

		return $this;
	}

	/**
	 * Performs the merge action
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function merge()
	{
		if($this->saveBackupBeforeMerge)
		{
			$this->saveBackup();
		}
		
		// Since the param bag has the merge functionality already, why not use it?
		$this->master->params()->merge($this->slave->params()->all());
		
		if($this->autoSaveMaster)
		{
			$this->master->save();
		}

		if($this->deleteSlaveOnMerge)
		{
			$this->slave->delete();
		}
	}

	/**
	 * Saves a backup using the param bag feature
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function saveBackup()
	{
		$this->master->params()->backup();
		$this->slave->params()->backup();
	}

	/**
	 * Restores the files
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function restore()
	{
		$this->master->params()->rollback();
		$this->slave->params()->rollback();

		// We should also save these so we know any changes have been fully reversed
		$this->master->save();
		$this->slave->save();
	}

	/**
	 * Returns the master file
	 *
	 * @return ConfigFile
	 * @author Dan Cox
	 */
	public function getMaster()
	{
		return $this->master;
	}

	/**
	 * Returns the slave file
	 *
	 * @return ConfigFile
	 * @author Dan Cox
	 */
	public function getSlave()
	{	
		return $this->slave;
	}
} // END class Merger
