<?php namespace Danzabar\Config\Exceptions;

/**
 * Exception class for when a non-existing file has been read
 *
 * @package Config
 * @subpackage Exceptions
 * @author Dan Cox
 */
class FileNotExists extends \Exception
{
	/**
	 * The given file name
	 *
	 * @var string
	 */
	protected $filename;

	/**
	 * Fire exception
	 *
	 * @param string $filename
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($filename, $code = 0, \Exception $previous = NULL)
	{
		$this->filename = $filename;

		parent::__construct("File does not exist: $filename", $code, $previous);
	}

	/**
	 * Returns the File name Var
	 *
	 * @return String
	 * @author Dan Cox
	 */
	public function getFilename()
	{
		return $this->filename;
	}
} // END class FileNotExists extends \Exception
