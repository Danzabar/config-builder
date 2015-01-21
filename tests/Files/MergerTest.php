<?php

use Danzabar\Config\Files\Merger,
	\Mockery as m;

/**
 * Test case for the merger class
 *
 * @package Config
 * @subpackage Tests\Files
 * @author Dan Cox
 */
class MergerTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * A mockery of config File class
	 *
	 * @var Object
	 */
	protected $master;

	/**
	 * A mockery of config File Class
	 *
	 * @var Object
	 */
	protected $slave;

	/**
	 * Set up test vars
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		$this->master = m::mock('Danzabar\Config\Files\ConfigFile');
		$this->slave = m::mock('Danzabar\Config\Files\ConfigFile');
	}

	/**
	 * Tear down test env
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function tearDown()
	{
		m::close();
	}

	/**
	 * Test Loading with default settings
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_loadWithDefaultSettings()
	{
		$this->master->shouldReceive('params')->andReturn($this->master);
		$this->master->shouldReceive('backup')->andReturn($this->master);
		$this->master->shouldReceive('merge')->with(Array('test' => 'value'))->andReturn($this->master);
		$this->master->shouldReceive('save');

		$this->slave->shouldReceive('params')->andReturn($this->slave);
		$this->slave->shouldReceive('backup')->andReturn($this->slave);
		$this->slave->shouldReceive('all')->andReturn(Array('test' => 'value'));

		$merge = new Merger;
		$merge
			->load($this->master, $this->slave)
			->merge();
	}

	/**
	 * Load some custom settings
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_loadAndDeleteSlaveOnMerge()
	{
		$this->master->shouldReceive('params')->andReturn($this->master);
		$this->master->shouldReceive('backup')->andReturn($this->master);
		$this->master->shouldReceive('merge')->with(Array('test' => 'value'))->andReturn($this->master);
		$this->master->shouldReceive('save');

		$this->slave->shouldReceive('params')->andReturn($this->slave);
		$this->slave->shouldReceive('backup')->andReturn($this->slave);
		$this->slave->shouldReceive('all')->andReturn(Array('test' => 'value'));
		$this->slave->shouldReceive('delete');
		
		$merge = new Merger(TRUE, TRUE, TRUE);

		$merge
			->load($this->master, $this->slave)
			->merge();
	}

	/**
	 * Oh noes, we dont like the outcome of the merge, or some other reasons, lets revert it
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_restoringAMergeGoneWrong()
	{
		$this->master->shouldReceive('params')->andReturn($this->master);
		$this->master->shouldReceive('backup')->andReturn($this->master);
		$this->master->shouldReceive('rollback');
		$this->master->shouldReceive('merge')->with(Array('test' => 'value'))->andReturn($this->master);
		$this->master->shouldReceive('save');

		$this->slave->shouldReceive('params')->andReturn($this->slave);
		$this->slave->shouldReceive('backup')->andReturn($this->slave);
		$this->slave->shouldReceive('rollback');
		$this->slave->shouldReceive('all')->andReturn(Array('test' => 'value'));
		$this->slave->shouldReceive('save');

		$merge = new Merger;
		$merge
			->load($this->master, $this->slave)
			->merge();

		$merge->restore();
	}


} // END class MergerTest extends \PHPUnit_Framework_TestCase
