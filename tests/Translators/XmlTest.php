<?php 

use Danzabar\Config\Translators\XML as Xml;


/**
 * Test cases for xml translator
 *
 * @package Config
 * @subpackage Test
 * @author Dan Cox
 */
class XmlTest extends \PHPUnit_Framework_TestCase
{
	
	/**
	 * An instance of xml translator class
	 *
	 * @var object
	 */
	protected $xml;

	/**
	 * The data array that we will be passing.
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Set up the data and xml class
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		$this->data = array(
			'test',
			'key' => 'value',
			'array2' => array(
				'multi' => array(
					'level',
					'with' => 'key'
				)
			)
		);

		$this->xml = new Xml();
		$this->xml->load($this->data);
	}

	/**
	 * Test the basic convert function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_translate()
	{
		// The array is valid
		$this->assertTrue( $this->xml->validate() );
		
		$check = new Xml();
		$check->load($this->xml->translate());
		
		$this->assertTrue( $check->validateNative() );	
	}

	/**
	 * Test the conversion back to Array, make sure it is an exact match of what we passed.
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_translateNative()
	{
		$php = new Xml();
		$php->load($this->xml->translate());

		// Is it valid xml
		$check = new Xml();
		$check->load($php->translateNative());

		$this->assertTrue( $check->validate() );
		
		$this->assertEquals( $this->data, $php->translateNative() );	
	}
	
} // END class XmlTest
