<?php namespace Danzabar\Config\Exception;

/**
 * Exception class for when we cannot find the appropriate translator class
 *
 * @package Config
 * @subpackage Exceptions
 * @author Dan Cox
 */
class InvalidTranslatorException extends \Exception
{
	
	/**
	 * The attempted extension
	 *
	 * @var string
	 */
	protected $extension;
	
	/**
	 * The file location
	 *
	 * @var string
	 */
	protected $file;
	
	/**
	 * Exception constructor	
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($message, $extension = NULL, $code = 0, \Exception $previous = NULL)
	{
		$this->extension = $extension;

		parent::__construct($message, $code, $previous);
	}

	/**
	 * Get the file extension attempted
	 *
	 * @return string
	 * @author Dan Cox
	 */
	public function getExtension()
	{
		return $this->extension;
	}


} // END class InvalidTranslatorException extends \Exception
