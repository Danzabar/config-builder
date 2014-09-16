<?php namespace Danzabar\Config;

use Danzabar\Config\Delegator;


/**
 * Writer class handles writing and updating config files using the translators
 *
 * @package Config
 * @subpackage Writer
 * @author Dan Cox
 */
class Writer
{
	
	/**
	 * The raw data
	 *
	 * @var String|Array
	 */
	protected $data;

	
	/**
	 * An instance of this specific translator class
	 *
	 * @var Object
	 */
	protected $translator;


	/**
	 * Load the nessecary translator and data.
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($extension, $data = Array())
	{
		$this->translator = Delegator::getByExtension($extension);
		
		// If the data is not in array form yet, convert it
		if(!is_array($data))
		{
			$this->translator->load($data);

			if($this->translator->validateNative())
			{
				$data = $this->translator->translateNative();
			}
		}

		$this->data = $data;
	}

	/**
	 * Load data into the data variable
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function load($data)
	{
		$this->data = $data;
	}

	/**
	 * Replaces values in the data array or in the data var passed
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function replace($match, $replacement = '', $data = NULL)
	{
		if(!is_null($data))
		{
			$this->data = $data;
		}
		
		$this->data = $this->recursiveReplace($match, $replacement, $this->data);		
	}

	/**
	 * Append data to the data variable
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function append($data)
	{	
		$this->data = array_merge($data, $this->data);
	}

	/**
	 * Prepend data to the data variable
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function prepend($data)
	{
		$this->data = array_merge($this->data, $data);
	}

	/**
	 * Writes to the native language of the translator, ie if json it will write to json.
	 *
	 * @return Mixed
	 * @author Dan Cox
	 */
	public function dump()
	{
		$this->translator->load($this->data);

		if($this->translator->validate())
		{
			return $this->translator->translate();
		}

		return false;
	}


	/**
	 * Used for custom needs, returns the translator loaded by extension
	 *
	 * @return Translator
	 * @author Dan Cox
	 */
	public function getTranslator()
	{
		return $this->translator;
	}
	
	/**
	 * Returns the data in array form
	 *
	 * @return Array
	 * @author Dan Cox
	 */
	public function getData()
	{
		return $this->data;
	}
	
	/**
	 * Recursively replaces array values.
	 *
	 * @return void
	 * @author Dan Cox
	 */
	private function recursiveReplace($match, $replacement, $data)
	{
		$json = json_encode($data);
		
		$json = str_replace($match, $replacement, $json);
		
		$arr = json_decode($json, TRUE);

		return $arr;
	}

} // END class Writer

