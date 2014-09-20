<?php namespace Danzabar\Config\Exception;

/**
 * Exception class for invalid content types.
 *
 * @package Config
 * @subpackage Exception
 * @author Dan Cox
 */
class InvalidContentTypeException extends \Exception
{

	/**
	 * The invalid contents string
	 *
	 * @var string
	 */
	protected $contents;
	
	/**
	 * The expected data type.
	 *
	 * @var string
	 */
	protected $expectedDataType;

	/**
	 * The exception
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($contents, $expectedDataType, $code = 0, Exception $previous = NULL)
	{
		$this->contents = $contents;
		$this->expectedDataType = $expectedDataType;

		parent::__construct("The contents read from file does not match the expected data type of: $this->expectedDataType", $code, $previous);
	}

	/**
	 * Return the contents of the file
	 *
	 * @return String
	 * @author Dan Cox
	 */
	public function getContents()
	{
		return $this->contents;
	}

	/**
	 * Returns the expected data type
	 *
	 * @return String
	 * @author Dan Cox
	 */
	public function getExpectedDataType()
	{
		return $this->expectedDataType;
	}

} // END class InvalidContentTypeException extends Exception
