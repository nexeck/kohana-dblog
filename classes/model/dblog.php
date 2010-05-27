<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
class Model_DBlog extends Model {

	public function getAllLogEntries() {
		return DB::select('*')->from(Kohana::config('dblog.default.db_table_name'))->execute()->as_array();
	}

	public function fieldNameToLocalizedHeader($dbFieldName) {
		switch ($dbFieldName) {
			case 'tstamp': return 'Date/time';
			default: return __(Inflector::humanize(ucfirst($dbFieldName)));
		}
	}

}