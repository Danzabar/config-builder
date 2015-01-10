Extending Extensions
====================

Although the config builder only officially supports JSON and YML, you can add your own extension classes and extend what its capable of, For example you could add support for .ini files, lets take a look at how we would do this:

		use Danzabar\Config\Data\Extensions\ExtensionInterface;

		Class IniExtension implements ExtensionInterface {
			
			// Contains either an array or string with ini data
			protected $data;

			public function load($data) {
				
				// We load the data
				$this->data = $data;

				return $this;
			}

			public function toNative() {
				// This is where you would convert the array back into ini format.
			}

			public function toArray() {
				// And this is where you convert ini data into an array
			}

			public function validateArray() {
				// To make sure its made a valid array
				// This function also acts as a recifier, if the array
				// Is recoverable, it can be done here.
			}
			
			public function validate() {
				// Similar to the function above, only the opposite direction.
			}

		}

Now we have our ini extension class, we need to add it to `Danzabar\Config\Data\ExtensionMap` class.

		
		$map = new ExtensionMap;
		$map->add('ini', new IniExtension);

And thats it! now you can add configuration files with a .ini extension!
