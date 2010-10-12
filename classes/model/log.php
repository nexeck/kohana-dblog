<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * @package    dblog
 * @author     Bastian Bräu
 */
class Model_Log extends ORM
{

	public static $time_format = '%Y-%m-%d %H:%M:%S';

	protected $_table_name = 'logs';
	protected $_labels = array();
	protected $_primary_key = 'id';
	protected $_primary_val = 'message';

	public function set_additional_data(array $additional_data)
	{
		foreach ($additional_data as $key => & $value)
		{
			$this->$key = $value;
		}
		return $this;
	}

	public function __get($column) {
		switch ($column) {
			case 'tstamp':
				$val = strftime(self::$time_format, parent::__get('tstamp'));
				break;
			default:
				$val = parent::__get($column);
		}
		return $val;
	}

	public function save()
	{
		$this->tstamp = time();
		return parent::save();
	}

}