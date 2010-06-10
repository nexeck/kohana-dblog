<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 * @todo       Move all the logic which is not ORM related to a seperate class
 *             so that other implementation can use it.
 */
class Model_DBlog_Entry_ORM extends ORM implements Model_DBlog_Entry_Storable {

	public function __construct($id = NULL) {
		$this->_table_name = DBlog::getTableName();
		$this->_primary_val = 'message';
		parent::__construct($id);
		$this->_load();
	}

	public function getFields() {
		return $this->_object;
	}

	public function getField($key) {
		return $this->$key;
	}

	public function getFormattedField($key) {
		switch ($key) {
			case 'tstamp': return date('Y-m-d H:i:s', $this->$key);
			default: return $this->$key;
		}
	}

	public function fieldNameToLocalizedHeader($fieldName) {
		try {
			switch ($fieldName) {
				case 'tstamp': return 'Date/time';
				default: return __(Inflector::humanize(ucfirst($fieldName)));
			}
		} catch (Exception $e) {
			throw new Kohana_Exception('Could not transform the field name :name', array(':name' => $fieldName));
		}
	}

	public function limit($itemsPerPage) {
		return parent::limit($itemsPerPage);
	}

	public function offset($offset) {
		return parent::offset($offset);
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

	public function save() {
		$this->tstamp = time();
		parent::save();
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