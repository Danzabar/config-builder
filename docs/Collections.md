Collections
===========

Collections allow you to group config files and query them similar to how you would use a database. To create a collection we first need an instance of the `Collection` class.

	use Danzabar\Config\Collections\Collection;

	$collection = new Collection;

Using this instance we can now "query" for files using the methods provided:

	// Set the search directory
	$collection->setDirectory('/directory');

	// Fetch all files from the search directory
	$collection->all();

	// Fetch files from a specific directory within the search directory
	$collection->whereIn('/test')->fetch();

	// Exclude a directory from the search
	$collection->excludeDir('/test')->all();

	// Exclude a file name
	$collection->exclude('testfile')->fetch();

	// Specify a custom filter callback
	$collection->filter( function (\SplFileInfo $file) {
		
		return $file->getExtension() == 'json';
	});

The collection class uses the Symfony Finder component, so you can use methods provided from that by fetching the finder from the collection instance:

	$collection->finder();

It will always filter the files in directories to make sure they match the file extensions registered with the `ExtensionMap`. 

The collection class will return results via the `CollectionResults` class, this class implements `Iterator`, `Countable`, `ArrayAccess` interfaces, which allows a collection result to be accessed in various ways.

	$results = $collection->fetch();

	count($results);

	$results[1];

	foreach ($results as $result)
	{
		echo $result->params()->test;
	}
