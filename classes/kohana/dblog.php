<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 * @copyright  (c) 2010 Bastian Bräu
 * @license    ISC http://opensource.org/licenses/isc-license.txt
 */
abstract class Kohana_DBlog {

	protected static $instance;

	protected $tableName;
	protected $defaultsForAdditionalFields = array();

	/**
	 * @param   string  type of message
	 * @param   string  message
	 * @param   string  details
	 * @param   array   values to replace in the message and details
	 * @param   array   values for additional fields, which must exist in the db table
	 * @return  void
	 */
	public static function add(
		$type, $message,
		$details = '', array $substitutionValues = array(), array $additionalData = array()) {
		$data = self::getInstance()->mergeAdditionalData($additionalData);
		if (! isset($data['tstamp']))
			$data['tstamp'] = time();
		$data['type'] = strtoupper($type);
		$data['message'] = strtr($message, $substitutionValues);
		$data['details'] = strtr($details, $substitutionValues);
		self::getInstance()->validate($data);
		$query = self::getInstance()->getInsertQuery($data);
		self::getInstance()->execInsertQuery($query);
		unset($query, $data);
	}

	public static function addKohanaMessage($type, $message, $time) {
		// TODO check time format
		self::add(
			$type,
			$message,
			'',
			array(),
			array('tstamp' => $time)
		);
	}

	protected function getInsertQuery(array $data) {
		return DB::insert(
			self::getInstance()->tableName,
			array_keys($data)
		)->values(array_values($data));
	}

	protected function execInsertQuery(Database_Query_Builder_Insert $query) {
		try {
			$query->execute();
		} catch (Database_Exception $e) {
			$this->handleDatabaseException($e);
		}
	}

	protected function validate(array $logData) {
		foreach ($logData as &$value)
			if (! is_string($value) && ! is_int($value))
				$this->handleInvalidDataException(new Kohana_Exception('Can only log string/int values, but got a :type.', array(':type' => gettype($value))));
	}

	protected function mergeAdditionalData(array $additionalData) {
		$data = $this->defaultsForAdditionalFields;
		foreach ($additionalData as $key => &$value)
			$data[$key] = $value;
		return $data;
	}

	protected function handleInvalidDataException(Kohana_Exception $e) {
		throw $e;
	}

	protected function handleDatabaseException(Database_Exception $e) {
		throw $e;
	}

	protected static function getInstance() {
		if (! isset(self::$instance)) {
			self::$instance = new DBlog();
		}
		return self::$instance;
	}

	protected function __construct() {
		$this->tableName = Kohana::config('dblog')->db_table_name;
	}

	protected function __clone() {}

}