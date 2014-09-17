<?php namespace Danzabar\Config;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Danzabar\Config\Writer;


/**
 * The builder class focuses on creating the various formats of files.
 *
 * @package Config
 * @subpackage Builder
 * @author Dan Cox
 */
class Builder
{

	/**
	 * The directory of the config files
	 *
	 * @var string
	 */
	protected $directory;

	/**
	 * An instance of the file system class
	 *
	 * @var object
	 */
	protected $fs;	

	/**
	 * An array of files that we will create
	 *
	 * @var array
	 */
	protected $files;
	
	/**
	 * An array of errors
	 *
	 * @var array
	 */
	protected $errors;

	/**
	 * Init the builder and lay down the base settings
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function __construct($directory, $chmod = '0755', $fs = NULL)
	{
		$this->directory = $directory;
		
		$this->fs = (!is_null($fs) ? $fs : new FileSystem);
		
		// If this directory does not exist, create it
		if(!$this->fs->exists($this->directory))
		{
			$this->fs->mkdir($this->directory, $chmod);	
		}	
	}

	/**
	 * Creates either a single file or multiple config files
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function make($files, $extension = 'json', $data = Array())
	{
		if(!is_array($files))
		{
			$this->files[$files] = array('extension' => $extension, 'data' => $data);
		}
		else {
			
			$this->cleanse($files);
		}

		// create all these files now by dumping a blank string;
		foreach($this->files as $file => $options)
		{
			try
			{
				$writer = new Writer($options['extension'], $options['data']);			
								
				$this->fs->dumpFile($this->directory . $file . '.' . $options['extension'], $writer->dump());

			} catch(\Exception $e) {
					
				$this->errors[] = array('file' => $file, 'message' => $e->getMessage());
			}
		}
	}

	/**
	 * Returns the errors array
	 *
	 * @return array
	 * @author Dan Cox
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * Gets the files currently stored in the class var
	 *
	 * @return array
	 * @author Dan Cox
	 */
	public function getFiles()
	{
		return $this->files;
	}

	/**
	 * Loops through array of files and gets them ready for file creation function
	 *
	 * @return array
	 * @author Dan Cox
	 */
	public function cleanse($files)
	{
		foreach($files as $file => $options)
		{
			if(is_numeric($file) && is_string($options))
			{
				$this->files[$options] = array('extension' => 'json', 'data' => array());
			}
			else {
					
				$this->files[$file] = array(
					'extension' => (isset($options['extension']) ? $options['extension'] : 'json'),
					'data' => (isset($options['data']) ? $options['data'] : array())
				);
			}
		}
	}


} // END class Builder
