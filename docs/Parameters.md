## Using Parameters

So once you've loaded a file, how do you use it? What exactly can you do with it? Well lets look at its basic usage first... Creating, Reading and Updating values from the actual configuration file. Lets say we created a new config file

	$file = new ConfigFile;
	$file->create('/directory/path/test.yml');

	// Now that the file has been loaded we have access to a ParamBag instance
	$file->params();

	// We can set new values
	$file->params()->foo = 'bar';

	// We can get set values
	$file->params()->foo; // bar

	// We can get check for set values
	isset($file->params()->bar) // false

	// We can get the params array back
	$file->params()->all();

	// We can perform a recursive search and replace on all the data
	$file->params()->recursiveReplace('search', 'replace');

Once we are done with the params, simply calling the `ConfigFile` classes save method will convert the array back into its native format and write it to the file. 

	$file->save();

Simples!
