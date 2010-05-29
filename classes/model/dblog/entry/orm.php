<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
class Model_DBlog_Entry_ORM extends ORM implements Model_DBlog_Entry_Storable {

	public function __construct($tableName) {
		$this->_table_name = $tableName;
		$this->_primary_val = 'message';
		parent::__construct();
		$this->tstamp = time();
	}

	public function setType($type) {
		$this->type = strtoupper($type);
		return $this;
	}

	public function setMessage($message) {
		$this->message = $message;
		return $this;
	}

	public function setDetails($details) {
		$this->details = $details;
		return $this;
	}

	public function setSubstitutionValues(array $substitutionValues) {
		$this->message = strtr($this->message, $substitutionValues);
		$this->details = strtr($this->details, $substitutionValues);
		return $this;
	}

	public function setAdditionalData(array $additionalData) {
		foreach ($additionalData as $key => &$value) {
			$this->$key = $value;
		}
		return $this;
	}

}