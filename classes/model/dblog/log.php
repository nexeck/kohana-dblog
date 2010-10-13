<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * @package    dblog
 * @author     Bastian Bräu
 */
class Model_DBlog_Log extends ORM
{

	public static $time_format = '%Y-%m-%d %H:%M:%S';

	protected $_labels = array(
		'id'      => 'ID',
		'tstamp'  => 'Date/time',
		'type'    => 'Type',
		'message' => 'Message',
		'details' => 'Details',
	);

	protected $_table_name = 'logs';
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
		switch ($column)
		{
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

	public function apply_filters($filter_src)
	{
		$filters = Arr::get($filter_src, 'log-filter', array());
		if (isset($filters['type']) AND $filters['type'] !== '')
		{
			$this->where('type', '=', strtoupper($filters['type']));
		}
		return $this;
	}

	public function as_array()
	{
		$object = array();
		foreach ($this->_object as $key => $val)
		{
			$object[$this->label($key)] = $this->__get($key);
		}
		// omitted $this->_related processing from super class
		return $object;
	}

	public function label($column) {
		return Arr::get($this->_labels, __($column), $column);
	}

	/**
	 * Get table name from config
	 *
	 * @return  void
	 */
	protected function _initialize()
	{
		$this->_table_name = Kohana::config('dblog.table');
		parent::_initialize();
	}

}