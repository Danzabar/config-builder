Loading a configuration file
============================

You will no doubt want to load a configuration file, this is really simple, you will just need an instance of the `Danzabar\Config\Files\ConfigFile` class

	$file = new ConfigFile;
	$file->load('/directory/to/file.json');

This will read the file, map out its details and load a `Danzabar\Config\Data\ParamBag` instance with the values from the file. Just so you can see how this works lets say we have this configuration file;

	{
		"test": "value" 
	}

This will be loaded in the ParamBag instance and you could use this like:

	$file->params()->test; // value;
	$file->params()->test = 'foo';

	// then you can save the new values
	$file->save();

Theres more documentation on the ParamBag class with gives you a better insight into its uses, check out the docs folder for more info.

## Saving into different formats

You can now save a file as a different format using the `saveAs` method, this will convert the data and save the file with the correct extension.

	$file->saveAs('json');
	
	$file->saveAs('yml');

## Deleting a file

You can delete a file too, just use the `delete` method on the instance of `ConfigFile`

	$file->delete();

Tip: after deleting a file, the files params remain, if you was to use the `save` method the file would remain.
