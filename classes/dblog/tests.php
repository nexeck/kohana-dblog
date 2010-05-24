<?php

class DBlog_Tests {

	private static $suite;

	public static function suite() {
		if (self::$suite instanceof PHPUnit_Framework_TestSuite) {
			return self::$suite;
		}
		$files = Kohana::list_files('../modules/dblog/tests/dblog');
		self::$suite = new PHPUnit_Framework_TestSuite();
		self::addTests(self::$suite, $files);
		return self::$suite;
	}

	public static function addTests(PHPUnit_Framework_TestSuite $suite, array $files) {
		foreach ($files as $file) {
			if (is_array($file)) {
				self::addTests($suite, $file);
			} else {
				if (is_file($file) AND substr($file, -strlen(EXT)) === EXT) {
					if (! strpos($file, 'TestCase'.EXT)) {
						$suite->addTestFile($file);
					} else {
						require_once($file);
					}
					PHPUnit_Util_Filter::addFileToFilter($file);
				}
			}
		}
	}

}