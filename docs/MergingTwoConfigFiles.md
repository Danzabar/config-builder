Merging Config Files
====================

The `Merger` class deals with merging `ConfigFile` Classes, there are several settings that you can mess around with to get the most out of it and you can set the auto backup so any changes can be reverted. Heres how you would use this:


	$file1; // Instance of Danzabar\Config\Files\ConfigFile;
	$file2; // Instance of Danzabar\Config\Files\ConfigFile;

	$merge = new Danzabar\Config\Data\Merger();

	$merge->load($file1, $file2);
	$merge->merge();

	// Now you can retreive the master file
	$file1 = $merge->getMaster();

	// Or if you have Auto Save settings, you can just refresh the instance of file1
	$file1->refresh();

	// If you have saved changes that need rolling back use this
	$merge->revert();

There are 3 settings to use with the Merger class, firstly theres Auto saving the master file, this is the first argument, then there is Auto saving a backup before merging, then there is deleting the slave file after merge, by default these are True, True, False respectively, If you wish to change this, pass boolean values into the constructor like:

	$AutoSaveMaster = True;
	$AutoSaveBackup = True;
	$DeleteSlave = False;

	new Merger($AutoSaveMaster, $AutoSaveBackup, $DeleteSlave);

	
