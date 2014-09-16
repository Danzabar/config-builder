<?php 

use Danzabar\Config\Translators\Json;


Class Test_Json extends \PHPUnit_Framework_TestCase
{
	/**
	 * The instance of the JSON translator
	 *
	 * @var Object
	 */
	protected $json;

	/**
	 * The data to be shared by tests
	 *
	 * @var Array
	 */
	protected $data;


	/**
	 * Setup variables for the test.
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function setUp()
	{
		$this->data = array(
			'test1',
			'test2',
			'test3' => array(
				'child',
				'child_parent' => array(
					'3rdlevel',
					array('mixed', 'array'),
					array('test4', 'test5')
				)
			)
		);

		$this->json = new Json();	

		$this->json->load($this->data);
	}
		
	/**
	 * Test the basic translation of Array to Json
	 *
	 * @return Boolean
	 * @author Dan Cox
	 */
	public function test_basic()
	{
		// This is a valid array so it should validate.
		$this->assertEquals( $this->json->validate(), TRUE);

		// Since it validated the results of translate should not return a NULL
		$this->assertTrue( !is_null($this->json->translate()) );
	}
	
	/**
	 * Checks the integrity of the json passed back, and makes sure it matches that
	 * of the data
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_jsonReturn()
	{	
		$our_json = json_encode($this->data, JSON_PRETTY_PRINT);

		$this->assertEquals($this->json->translate(), $our_json);
	}

	/**
	 * Trivial - but checks the validation of array
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_BadArrayValidation()
	{
		$test1 = new Json();
		$test2 = new Json();
		
		// Load data
		$test1->load('Passing String');
		$test2->load((object) array('passing', 'object'));

		$this->assertFalse( $test1->validate() );
		$this->assertFalse( $test2->validate() );
	}

	/**
	 * Tests the ability to translate back to exact same array i passed it in the first test
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_nativeTranslate()
	{
		$php = new Json();
		$php->load($this->json->translate());

		$this->assertTrue( $php->validateNative() );
		$this->assertEquals($this->data, $php->translateNative());
	}

	/**
	 * Test the ability to reckognise bad JSON
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_nativeValidate()
	{
		$badJson = "{'bad':'json',}";	

		$php = new Json();
		$php->load($badJson);

		$this->assertFalse( $php->validateNative() );
	}
}
