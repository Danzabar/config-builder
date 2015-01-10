<?php namespace Danzabar\Config\Files;

/**
 * The file info class allows us to get and mock file information
 *
 * @package Config
 * @subpackage FIles
 * @author Dan Cox
 */
class FileInfo
{
	/**
	 * The file name
	 *
	 * @var string
	 */
	public $filename;

	/**
	 * The extension
	 *
	 * @var string
	 */
	public $extension;

	/**
	 * The directory
	 *
	 * @var string
	 */
	public $directory;

	/**
	 * Gather Details
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function load($file)
	{
		$details = pathinfo($file);
		$this->filename = $details['basename'];
		$this->extension = $details['extension'];
		$this->directory = $details['dirname'];
	}

} // END class FileInfo
