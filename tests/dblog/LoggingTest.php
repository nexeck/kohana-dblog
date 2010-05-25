<?php

class DBlog_LoggingTest extends PHPUnit_Framework_TestCase {

	protected $dbTableName;

	protected function setUp() {
		$this->dbTableName = Kohana::config('dblog')->db_table_name;
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
		if (count($result) != 1)
			$this->fail('Expected exactly 1 row as result.');
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
		if (count($result) != 1)
			$this->fail('Expected exactly 1 row as result.');
		$this->assertEquals(strtoupper($type), $result[0]['type']);
		$this->assertEquals($details, $result[0]['details']);
		$this->dbCleanup($result[0]['id']);
	}

	public function testNonexistantAdditionalField() {
		$type = 'test';
		$message = uniqid();
		$additionalFields = array('idontexist' => 'novalue');
		try {
			DBlog::add($type, $message, '', array(), $additionalFields);
		} catch (Database_Exception $e) {
			return;
		}
		$this->fail('Invalid additional field should have thrown an exception.');
	}

	protected function dbCleanup($id) {
		DB::delete($this->dbTableName)->where('id', '=', $id)->execute();
	}

}