<?php namespace Danzabar\Config\Exceptions;

/**
 * The invalid extension exception class
 *
 * @package Config
 * @subpackage Exceptions
 * @author Dan Cox
 */
class InvalidExtension extends \Exception
{
	/**
	 * The tried extension
	 *
	 * @var string
	 */
	protected $extension;

	/**
	 * Fire exception
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($extension, $code = 0, \Exception $previous = NULL)
	{
		$this->extension = $extension;

		parent::__construct("The requested extension is invalid: $extension", $code, $previous);
	}

	/**
	 * Returns the extension
	 *
	 * @return String
	 * @author Dan Cox
	 */
	public function getExtension()
	{
		return $this->extension;
	}
} // END class InvalidExtensions extends \Exception
