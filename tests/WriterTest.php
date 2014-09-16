<?php require_once __DIR__.'/environment.php';

use Danzabar\Config\Writer;


/**
 * Test case for the writer class
 *
 * @package Config
 * @subpackage Test
 * @author Dan Cox
 */
class WriterTest extends \PHPUnit_Framework_TestCase
{
	
	/**
	 * Simple test to make sure it can delegate correctly
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_useDelegate()
	{
		$writer = new Writer('json', Array());
	
		$this->assertInstanceOf('Danzabar\Config\Translators\Json', $writer->getTranslator());
	}

	/**
	 * Test the loading and conversion of native data
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_conversion()
	{
		$writer = new Writer('json', '{"valid":"json"}');

		$this->assertEquals($writer->getData(), Array('valid' => 'json'));
	}

	/**
	 * Test the append function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_append()
	{
		$writer = new Writer('json', '{"valid":"json"}');
	
		$writer->append(array('more' => 'value'));

		$this->assertEquals($writer->getData(), Array('more' => 'value', 'valid' => 'json'));
	}

	/**
	 * Test the prepend function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_prepend()
	{
		$writer = new Writer('json', '{"valid":"json"}');
		
		$writer->prepend(array('more' => 'value'));

		$this->assertEquals($writer->getData(), Array('valid' => 'json', 'more' => 'value'));
	}

	/**
	 * Test the replace function
	 *
	 * @return void
	 * @author Dan Cox
	 */
	public function test_replace()
	{
		$writer = new Writer('json');
		
		$writer->load(Array('multi' => array('level', 'array'), 'test2' => 'level'));

		$writer->replace('level', 'pass');

		$test = $writer->getData();

		$this->assertTrue( !in_array('level', $test) );
		$this->assertTrue( !in_array('level', $test['multi']) );
	}

} // END class WriterTest extends \PHPUnit_Framework_TestCase
