<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
class Model_DBlog_Entry {

	public static function factory($tableName) {
		$className = Kohana::config('dblog.default.log_entry_class');
		return new $className($tableName);
	}

}