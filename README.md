[![Build Status](https://travis-ci.org/Danzabar/config-builder.svg?branch=master)](https://travis-ci.org/Danzabar/config-builder) [![Coverage Status](https://img.shields.io/coveralls/Danzabar/config-builder.svg)](https://coveralls.io/r/Danzabar/config-builder?branch=master)

# Config Builder

The config builder allows you to raise configuration files of several formats pre populate them and edit them with ease, its ideal to use with frameworks that require dynamic configurations for things like database connections or services.

## Installation

Install with composer.
	
	"danzabar/config":"dev-master"

## Building files

You can use the `Builder` class to quickly raise configuration files, for example:

	use Danzabar\Config\Builder;

	$builder = new Builder($directory, '0775');

	// Now we can create either a single file, or multiple
	$builder->make('single-file', 'json', Array('pre' => 'populate'));

	$builder->make(Array(
		'file_name' => array('extension' => 'yml', 'data' => array('optional')
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





