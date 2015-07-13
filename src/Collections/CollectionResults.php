<?php namespace Danzabar\Config\Collections;

/**
 * The Iterator Results Class
 *
 * @package Config
 * @subpackage Collections
 * @author Dan Cox
 */
class CollectionResults implements \Iterator, \Countable, \ArrayAccess
{

	/**
	 * An Array containing instances of the ConfigFile class
	 *
	 * @var Array
	 */
	protected $records = Array();

	/**
	 * Set up class dependencies
	 *
	 * @param Array $records
	 * @author Dan Cox
	 */
	public function __construct(Array $records = Array())
	{
		$this->records = $records;
	}

	/**
	 * Rewind method required by Iterator implementation
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function rewind()
	{
		reset($this->records);
	}

	/**
	 * Returns the array element at the current position
	 *
	 * @return Mixed
	 * @author Dan Cox
	 */
	public function current()
	{
		return current($this->records);
	}

	/**
	 * Key method required by Iterator implementation
	 *
	 * @return String
	 * @author Dan Cox
	 */
	public function key()
	{
		return key($this->records);
	}

	/**
	 * Returns the next array element from records
	 *
	 * @return Mixed
	 * @author Dan Cox
	 */
	public function next()
	{
		return next($this->records);
	}

	/**
	 * Returns a boolean value representing the validity of the array
	 *
	 * @return Boolean
	 * @author Dan Cox
	 */
	public function valid()
	{
		return (!is_null(key($this->records)) && key($this->records) !== false);
	}

	/**
	 * Returns a count of the array
	 *
	 * @return Integer
	 * @author Dan Cox
	 */
	public function count()
	{
		return count($this->records);
	}

	/**
	 * Offset set method required by Array Access implementation
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function offsetSet($offset, $value)
	{
		if (is_null($offset))
		{
			$this->records[] = $value;

		} else {
			
			$this->records[$offset] = $value;
		}
	}

	/**
	 * Inverse of the Offset Set method
	 *
	 * @return Mixed
	 * @author Dan Cox
	 */
	public function offsetGet($offset)
	{
		return $this->records[$offset];
	}

	/**
	 * unsets array by key
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function offsetUnset($offset)
	{
		unset($this->records[$offset]);
	}

	/**
	 * Returns Boolean value representing whether the offset exists
	 *
	 * @return Boolean
	 * @author Dan Cox
	 */
	public function offsetExists($offset)
	{
		return array_key_exists($offset, $this->records);
	}


} // END class CollectionResults implements \Iterator, \Countable, \ArrayAccess
