Creating a new configuration file
=================================

So as well as loading a configuration file, you can create them. To do this you will need the `Danzabar\Config\Data\ConfigFile` class and a directory that can be saved to.

	$file = new ConfigFile;
	$file->create('/directory/to/file.yml');

This will create the file with a blank string and load it which means theres no different methods to creating and loading other than the initial create method.

