<?php namespace Danzabar\Config\Translators;

use Symfony\Component\Yaml;

/**
 * Yaml config translator class
 *
 * @package Config
 * @subpackage Translators
 * @author Dan Cox
 */
class YamlTranslator implements Translator
{
	
	/**
	 * An array of data or YAML string
	 *
	 * @var Mixed
	 */
	protected $data;
	

	/**
	 * Loads the data
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function load($data)
	{
		$this->data = $data;
	}

	/**
	 * Validates the array can be used for YAML parser
	 *
	 * @return Boolean
	 * @author Dan Cox
	 */
	public function validate()
	{
		return (is_array($this->data));
	}

	/**
	 * Converts a PHP array to Yaml Format
	 *
	 * @return String
	 * @author Dan Cox
	 */
	public function translate()
	{
		$writer = new Yaml\Dumper();

		return $writer->dump($this->data);
	}

	/**
	 * Validates a Yaml string
	 *
	 * @return Boolean
	 * @author Dan Cox
	 */
	public function validateNative()
	{
		try
		{
			Yaml\Yaml::parse($this->data);

		} catch(Yaml\Exception\ParseException $e)
		{
			return false;
		}

		return true;
	}

	/**
	 * Converts Yaml To PHP Array
	 *
	 * @return Array
	 * @author Dan Cox
	 */
	public function translateNative()
	{
		return Yaml\Yaml::parse($this->data);
	}

} // END class Yaml implements Translator
