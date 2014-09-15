<?php namespace Danzabar\Config\Translators;

/**
 * Translates XML objects into an array
 *
 * @package Config
 * @subpackage Translator
 * @author Dan Cox
 */
class XML implements Translator
{
	
	/**
	 * Either XML object or Array.
	 *
	 * @var array|object
	 */
	protected $data;
	
	/**
	 * Loads the data
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($data)
	{
		$this->data = $data;
	}

	/**
	 * Takes an array and returns XML
	 *
	 * @return string
	 * @author Dan Cox
	 */
	public function translate()
	{	
		$xml = new \SimpleXMLElement('<root/>');
		
		$this->buildXML($this->data, $xml);

		return $xml->asXML();
	}

	/**
	 * Validates an array against the XML format
	 *
	 * @return Boolean
	 * @author Dan Cox
	 */
	public function validate()
	{
		return (is_array($this->data));
	}

	/**
	 * Translates XML back into Array
	 *
	 * @return Array
	 * @author Dan Cox
	 */
	public function translateNative()
	{
		$toJson = json_encode(simplexml_load_string($this->data));

		return json_decode(str_replace('xml_item_', '', $toJson), TRUE);
	}

	/**
	 * Validates XML data
	 *
	 * @return Boolean
	 * @author Dan Cox
	 */
	public function validateNative()
	{
		libxml_use_internal_errors(true);
		
		$xml = simplexml_load_string($this->data);

		$errors = libxml_get_errors();

		return empty($errors);
	}

	/**
	 * Recursively builds xml by looping through array.
	 *
	 * @return void
	 * @author Dan Cox
	 */
	private function buildXML($array, &$xml)
	{
		foreach($array as $key => $value) 
		{
			if(is_array($value)) 
			{
				if(!is_numeric($key))
				{
					$node = $xml->addChild("$key");
					$this->buildXML($value, $node);
				}
				else {
					$node = $xml->addChild("xml_item_$key");
					$this->buildXML($value, $node);
				}
			}
			else {	
				if(!is_numeric($key))
				{
					$xml->addChild($key, htmlspecialchars($value));
				}
				else {
					$xml->addChild("xml_item_$key", htmlspecialchars($value));
				}
			}
		}	
	}

} // END class XML
