<?php namespace Danzabar\Config\Exception;


/**
 * The directory or file not found exception class
 *
 * @package Config
 * @subpackage Exceptions
 * @author Dan Cox
 */
class NotFoundException extends \Exception
{
	/**
	 * The directory path
	 *
	 * @var string
	 */
	private $path;
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($message, $code = 0, \Exception $previous = NULL, $path = NULL)
	{
		$this->path = $path;

		parent::__construct($message, $code, $previous);
	}

	/**
	 * Return the path value
	 *
	 * @return string
	 * @author Dan Cox
	 */
	public function getPath()
	{
		return $this->path;
	}
	

} // END class NotFoundException extends Exception
