<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
class Model_DBlog_Order extends Model
{

	const ASC = 'ASC';
	const DESC = 'DESC';

	private $directions = array
	(
		'tstamp' => self::ASC,
		'type' => self::DESC,
	);

	public function __construct()
	{
		if ($this->is_order_set())
			foreach ($this->directions as $field => &$dir)
				if ($this->is_order_set_for($field))
					$dir = $this->get_inverted_direction_for($field);
	}

	public function __get($field)
	{
		if (isset($this->directions[$field]))
			return $this->directions[$field];
		else
			return self::DESC;
	}

	private function is_order_set()
	{
		return isset($_GET['order_dir']) && isset($_GET['order_by']);
	}

	private function is_order_set_for(&$field)
	{
		// assert isset($_GET['order_dir'])): checked before in isOrderSet()
		return $_GET['order_by'] == $field;
	}

	private function get_inverted_direction_for(&$field)
	{
		// assert isset($_GET['order_dir'])): checked before in isOrderSet()
		return (strtoupper($_GET['order_dir']) == self::DESC) ? self::ASC : self::DESC;
	}

}