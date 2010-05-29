<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
class Model_DBlog extends Model {

	public function fieldNameToLocalizedHeader($dbFieldName) {
		try {
			switch ($dbFieldName) {
				case 'tstamp': return 'Date/time';
				default: return __(Inflector::humanize(ucfirst($dbFieldName)));
			}
		} catch (Exception $e) {
			throw new Kohana_Exception('Could not transform the field name :name', array(':name' => $dbFieldName));
		}
	}

	public function getFormattedLogs() {
		$logs = $this->getAllLogEntries();
		foreach ($logs as &$log) {
			foreach ($log as $fieldName => &$fieldValue) {
				$fieldValue = $this->getFormattedValueByType($fieldName, $fieldValue);
			}
		}
		return $logs;
	}

	public function getAllLogEntries() {
		return DB::select('id', 'tstamp', 'type', 'message')
			->from(Kohana::config('dblog.default.db_table_name'))
			->execute()
			->as_array();
	}

	public function getSingleLog($id) {
		return DB::select('*')
			->from(Kohana::config('dblog.default.db_table_name'))
			->where('id', '=', $id)
			->execute()
			->current();
	}

	protected function getFormattedValueByType($type, $value) {
		try {
			switch ($type) {
				case 'tstamp': return date('Y-m-d H:i:s', $value);
				default: return Text::limit_chars($value, 40, ' …', TRUE);
			}
		} catch (Exception $e) {
			throw new Kohana_Exception('Could not format log entry field :field', array(':field' => $type));
		}
	}

}