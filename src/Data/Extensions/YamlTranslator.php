<?php namespace Danzabar\Config\Data\Extensions;

use Symfony\Component\Yaml,
	Danzabar\Config\Data\Extensions\ExtensionInterface;

/**
 * Yaml config translator class
 *
 * @package Config
 * @subpackage Translators
 * @author Dan Cox
 */
class YamlTranslator implements ExtensionInterface
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
	 * @return YamlTranslator
	 * @author Dan Cox
	 */
	public function load($data)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * Validates the array can be used for YAML parser
	 *
	 * @return Boolean
	 * @author Dan Cox
	 */
	public function validateArray()
	{
		return (is_array($this->data));
	}

	/**
	 * Converts a PHP array to Yaml Format
	 *
	 * @return String
	 * @author Dan Cox
	 */
	public function toNative()
	{
		$writer = new Yaml\Dumper();

		return $writer->dump($this->data, 2);
	}

	/**
	 * Validates a Yaml string
	 *
	 * @return Boolean
	 * @author Dan Cox
	 */
	public function validate()
	{
		try
		{
			Yaml\Yaml::parse($this->data);

		} catch(\Exception $e)
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
	public function toArray()
	{
		return Yaml\Yaml::parse($this->data);
	}
} // END class Yaml implements Translator
