<?php namespace Danzabar\Config;

use Danzabar\Config\Delegator;

/**
 * Reader for files
 *
 * @package Config
 * @subpackage Reader
 * @author Dan Cox
 */
class Reader
{
	
	/**
	 * An instance of the specific translator class
	 *
	 * @var Object
	 */
	protected $translator;
	
	/**
	 * The file we are reading, ie "test.json"
	 *
	 * @var string
	 */
	protected $file;
	
	/**
	 * The raw file output
	 *
	 * @var Mixed
	 */
	protected $raw;	

	/**
	 * Stored translation of file
	 *
	 * @var Mixed
	 */
	protected $translated;

	/**
	 * The file extension
	 *
	 * @var string
	 */
	protected $extension;

	/**
	 * Read the file
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($file)
	{
		$this->file = $file;
	}

} // END class Reader

