<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * @package    dblog
 * @author     Bastian Bräu
 */
class Model_DBlog_Log extends ORM
{

	protected $_created_column = array('column' => 'created', 'format' => TRUE);

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

	public function apply_filters($filter_src)
	{
		$filters = Arr::get($filter_src, 'log-filter', array());
		if (isset($filters['type']) AND $filters['type'] !== '')
		{
			$this->where('type', '=', strtoupper($filters['type']));
		}
		return $this;
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