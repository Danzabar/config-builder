<?php

use Danzabar\Config\Collection;

/**
 * A Test collection class, extends the collection facade class and sets variables to enable easy to use collections.
 *
 * @package Config
 * @subpackage Tests
 * @author Dan Cox
 */
class TestCollection extends Collection
{
	
	/**
	 * Set up the collection
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct()
	{
		static::$directory = __DIR__.'/Files/';
		$this->fileName = 'testFile.json';

		parent::__construct();
	}

} // END class TestCollection extends Collection
