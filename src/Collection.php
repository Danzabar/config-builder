<?php namespace Danzabar\Config;

use Danzabar\Config\Collections\CollectionFactory;

/**
 * Collection class to iniate and extend from
 *
 * @package Config
 * @subpackage Collections
 * @author Dan Cox
 */
class Collection extends CollectionFactory
{

	/**
	 * The target file name
	 *
	 * @var string
	 */
	protected $fileName;


	/**
	 * Build up core collection features
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($fileName = NULL, $directory = NULL)
	{
		if(!is_null($fileName))
		{
			$this->fileName = $fileName;
		}
		
		if(!is_null($directory))
		{
			static::$directory = $directory;
		}	

		parent::__construct();
	}

	/**
	 * Sets the directory
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public static function setDirectory($directory)
	{
		static::$directory = $directory;
	}

} // END class Collection extends CollectionFactory

