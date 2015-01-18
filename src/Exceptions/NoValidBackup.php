<?php namespace Danzabar\Config\Exceptions;

/**
 * Exception class for when a rollback is called with no valid backup
 *
 * @package Config
 * @subpackage Exceptions
 * @author Dan Cox
 */
class NoValidBackup extends \Exception
{
	/**
	 * Array of params in the bag
	 *
	 * @var Array
	 */
	protected $params;

	/**
	 * Fire exception
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($params = Array(), $code = 0, \Exception $previous = NULL)
	{
		$this->params = $params;

		parent::__construct("Call to rollback method when no valid backup has been made.", $code, $previous);
	}

	/**
	 * Returns the params
	 *
	 * @return Array
	 * @author Dan Cox
	 */
	public function getParams()
	{
		return $this->params;
	}

} // END class NoValidBackup extends \Exception
