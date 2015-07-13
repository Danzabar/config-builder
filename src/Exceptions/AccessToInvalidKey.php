<?php namespace Danzabar\Config\Exceptions;

/**
 * Exception class for trying to access an invalid param bag key
 *
 * @package Config
 * @subpackage Exceptions
 * @author Dan Cox
 */
class AccessToInvalidKey extends \Exception
{
	/**
	 * The key attempted
	 *
	 * @var string
	 */
	protected $attemptedKey;

	/**
	 * Fire exception
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($key, $code = 0, \Exception $previous = NULL)
	{
		$this->attemptedKey = $key;

		parent::__construct("Attempted access to invalid parameter key: $key", $code, $previous);
	}

	/**
	 * Returns the Attempted Key var
	 *
	 * @return String
	 * @author Dan Cox
	 */
	public function getAttemptedKey()
	{
		return $this->attemptedKey;
	}
} // END class AccessToInvalidKey extends \Exception
