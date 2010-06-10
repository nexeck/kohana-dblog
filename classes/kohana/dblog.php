<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
abstract class Kohana_DBlog {

	protected static $instance;

	protected $tableName;

	/**
	 * @param   string  type of message
	 * @param   string  message
	 * @param   string  details
	 * @param   array   values to replace in the message and details
	 * @param   array   values for additional fields, which must exist in the db table
	 * @return  void
	 */
	public static function add($type,
	                           $message,
	                           $details = '',
	                     array $substitutionValues = array(),
	                     array $additionalData = array()) {
		try {
			Model_DBlog_Entry::factory()
				->setType($type)
				->setMessage($message)
				->setDetails($details)
				->setSubstitutionValues($substitutionValues)
 				->setAdditionalData($additionalData)
				->save();
		} catch (Exception $e) {
			self::getInstance()->handleException(new DBlog_Exception('Log entry could not be saved: '.$e->getMessage()));
		}
	}

	public static function addKohanaMessage($type, $message, $time) {
		// TODO check time format (unix time stamp)
		// TODO (?) split message on first : and use remainder as details
		self::add($type, $message, '', array(), array('tstamp' => $time));
	}

	public static function getTableName() {
		return self::getInstance()->tableName;
	}

	protected function handleException(DBlog_Exception $e) {
		throw $e;
	}

	protected static function getInstance() {
		if (! isset(self::$instance)) {
			self::$instance = new DBlog();
		}
		return self::$instance;
	}

	protected function __construct() {
		$this->tableName = (Kohana::$environment === Kohana::TESTING)
			? Kohana::config('dblog.testing.db_table_name')
			: Kohana::config('dblog.default.db_table_name');
	}

	protected function __clone() {}

}