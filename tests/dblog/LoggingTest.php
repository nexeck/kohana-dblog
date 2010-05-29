<?php

class DBlog_LoggingTest extends PHPUnit_Framework_TestCase {

	protected $dbTableName;

	protected function setUp() {
		$this->dbTableName = Kohana::config('dblog.testing.db_table_name');
	}

	public function testRequiredParametersDbInsert() {
		$type = 'test';
		$message = uniqid();
		$message .= 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet consectetur velit. Mauris quis eleifend urna. Integer sed metus ante, sed volutpat sem.';
		DBlog::add($type, $message);
		try {
			$result = DB::select('*')->from($this->dbTableName)->where('message', '=', $message)->execute()->as_array();
		} catch (Database_Exception $e) {
			$this->fail('Database error: '.$e->getMessage());
		}
		$this->assertEquals(1, count($result), 'Expected exactly 1 row as result.');
		$this->assertEquals(strtoupper($type), $result[0]['type']);
		$this->assertEquals('', $result[0]['details']);
		$this->dbCleanup($result[0]['id']);
	}

	public function testSubstitution() {
		$type = 'test';
		$message = uniqid();
		$message .= 'Lorem ipsum :dolor sit amet, consectetur adipiscing elit. Nunc sit amet consectetur velit. Mauris :quis eleifend urna. Integer sed metus ante, sed volutpat sem.';
		$details = chr(10).chr(10).':dolor'.chr(10).chr(10).':quis'.chr(10).chr(10);
		$substitution = array(
			':dolor' => 'subst1',
			':quis' => 'subst2',
		);
		DBlog::add($type, $message, $details, $substitution);
		$message = strtr($message, $substitution);
		$details = strtr($details, $substitution);
		try {
			$result = DB::select('*')->from($this->dbTableName)->where('message', '=', $message)->execute()->as_array();
		} catch (Database_Exception $e) {
			$this->fail('Database error: '.$e->getMessage());
		}
		$this->assertEquals(1, count($result), 'Expected exactly 1 row as result.');
		$this->assertEquals(strtoupper($type), $result[0]['type']);
		$this->assertEquals($details, $result[0]['details']);
		$this->dbCleanup($result[0]['id']);
	}

	public function testNonexistantAdditionalField() {
		$message = uniqid();
		$additionalFields = array('idontexist' => 'novalue');
		try {
			DBlog::add('test', $message, '', array(), $additionalFields);
		} catch (Exception $e) {
			return;
		}
		$this->fail('Invalid additional field should have thrown an exception.');
	}

	public function testInvalidAdditionalFields() {
		$type = 'test';
		$message = uniqid();
		$additionalFields = array(
			'addint' => 'xyz',
		);
		DBlog::add($type, $message, '', array(), $additionalFields);
		try {
			$result = DB::select('*')->from($this->dbTableName)->where('message', '=', $message)->execute()->as_array();
		} catch (Database_Exception $e) {
			$this->fail('Database error: '.$e->getMessage());
		}
		$this->assertEquals(1, count($result), 'Expected exactly 1 row as result.');
		$this->assertNotEquals('xyz', $result[0]['addint'], 'Received string value from integer database field.');
		$this->assertEquals('0', $result[0]['addint']);
		$this->dbCleanup($result[0]['id']);
	}

	public function testValidAdditionalFields() {
		$type = 'test';
		$message = uniqid();
		$additionalFields = array(
			'addint' => '123',
			'addtext' => 'xyz',
		);
		DBlog::add($type, $message, '', array(), $additionalFields);
		try {
			$result = DB::select('*')->from($this->dbTableName)->where('message', '=', $message)->execute()->as_array();
		} catch (Database_Exception $e) {
			$this->fail('Database error: '.$e->getMessage());
		}
		$this->assertEquals(1, count($result), 'Expected exactly 1 row as result.');
		$this->assertEquals('123', $result[0]['addint']);
		$this->assertEquals('xyz', $result[0]['addtext']);
		$this->dbCleanup($result[0]['id']);
	}

	protected function dbCleanup($id) {
		DB::delete($this->dbTableName)->where('id', '=', $id)->execute();
	}

}