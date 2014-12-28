[![Build Status](https://travis-ci.org/Danzabar/config-builder.svg?branch=master)](https://travis-ci.org/Danzabar/config-builder) [![Coverage Status](https://img.shields.io/coveralls/Danzabar/config-builder.svg)](https://coveralls.io/r/Danzabar/config-builder?branch=master) [![Latest Stable Version](https://poser.pugx.org/danzabar/config/v/stable.svg)](https://packagist.org/packages/danzabar/config) [![Total Downloads](https://poser.pugx.org/danzabar/config/downloads.svg)](https://packagist.org/packages/danzabar/config) [![Latest Unstable Version](https://poser.pugx.org/danzabar/config/v/unstable.svg)](https://packagist.org/packages/danzabar/config) [![License](https://poser.pugx.org/danzabar/config/license.svg)](https://packagist.org/packages/danzabar/config)

# Config Builder

The config builder allows you to raise configuration files of several formats pre populate them and edit them with ease, its ideal to use with frameworks that require dynamic configurations for things like database connections or services.

## Installation

Install with composer.
	
	"danzabar/config":"1.3.0"

## Using the File Collections

Collections have now been added which allow you to interact with the data from files or create a new file in an ORM like fashion. You can use this either with the `Collection` class or by extending the `Collection` class;

	use Danzabar\Config\Collection;

	// Set the directory to look in
	Collection::setDirectory('test/directory');

	// Create a new File
	$collection = new Collection('newfile.json');

	// Open an existing file
	$collection = new Collection('existing.json');

The `Collection` class uses the magic getter and setter functions so to interact with the data you can:

	$collection->foo = 'bar';

	$collection->foo;

Once you are done with your editions you can save the changes to file;

	$collection->save();

## Extending the Collection Class

To create seperate classes for files you can extend from the `Collection` class to have an ORM like setup with your config files.

	Class FileCollection extends Collection {
		
		public function __construct()
		{
			static::$directory = '/test/dir';
			$this->fileName = 'filename.json';

			parent::__construct();
		}
	}

Now you can create instances of the FileCollection class you have created without providing anymore configuration options and edit/create data for it.

	$collection = new FileCollection();

	$collection->foo = 'bar';
	$collection->save();

## Building files

You can use the `Builder` class to quickly raise configuration files, for example:

	use Danzabar\Config\Builder;

	$builder = new Builder($directory, '0775');

	// Now we can create either a single file, or multiple
	$builder->make('single-file', 'json', Array('pre' => 'populate'));

	$builder->make(Array(
		'file_name' => array('extension' => 'yml', 'data' => array('optional'))
	));

## Reading files

Using the `Reader` Class you can get the contents of the file returned as an array, you can also access an instance of the `Writer` class for that file, which allows you to edit the files contents directly.

	use Danzabar\Config\Reader;

	$reader = new Reader($directory);

	$reader->read($filename);
	
	// Return the raw contents
	$reader->getRaw();

	// Get the array version
	$reader->getTranslated();

	// Get a writer for the file
	$reader->getWriter();

## Writer

The writer gives you tools to manipulate the data and write the results back into the file, you can get the writer from opening a reader class on the filer you wish. You can also create a new instance of the writer manually and specify a file to write to.

	use Danzabar\Config\Writer;

	// To get a writer manually the data variable can either be an array or your target extension in this case json.
	$writer = new Writer('json', $data);

	// If you want to specify different data, use the load method, although this must be an array.
	$writer->load($differentData);

All data in the writer will eventually be converted to an array, there are some tools to help you manipulate the `$data` property

	// Recursive search and replace
	$writer->replace($search, $replacement);

	// Append data
	$writer->append($appendingData);

	// Prepend data
	$writer->prepend($prependingData);

If you are using the writer independently you might want to get access to the data, converted data string or the translator class there are methods for this too;

	// Get the data
	$writer->getData();

	// Get translator
	$writer->getTranslator();

	// Translated/Converted data string
	$writer->dump();
	
## Converter

The `Converter` class allows you to convert a file to a different format, currently XML is not supported when using this feature. To use the converter first create an instance of it;

	use Danzabar\Config\Converter;

	$converter = new Converter($file, $desiredExtension);
	
	// Now we can just simply convert
	$converter->convertFile();

If you are testing or you want to make sure a conversion will go smooth before commiting to creating a file, you can use the converter a bit differently to check its outcome first;

	// Process the data conversion, but dont write to a file
	$converter->process();

	// Now we can access the converted data
	$converter->getDump();

	// We can access the raw file contents
	$converter->getRawOutput();

	// We can get the instance of the translator involved
	$converter->getTranslator();

	// We can also get the extension of the file and its desired extension
	$converter->getFromExtension();
	$converter->getToExtension();

## Adding a translator via the Delegator Class

You can add your own translator class using the `Delegator` Class, first you must make your translator that implements `Danzabar\Config\Translators\Translator` it must contain the following functions:

* load - accepts an array, which will be the data;
* validate - validates the array thats passed to it. 
* translate - translates the array into the native format
* validateNative - validates its native data against its own rules
* translateNative - translates from native format to array

Once you have your translator, before using it you need to tell the delegator that you wish to use this.
	
	// Be sure to build the default extension mappings first
	Delegator::buildDefaultExtensionMap();
	
	Delegator::addExtension('newextension', new ExtensionTranslator);


# Contributing

Contributing is very welcome, however please make sure there are tests for any new functionality added.
