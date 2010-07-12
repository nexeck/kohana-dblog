<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
class Model_DBlog extends Model
{

	protected $pagination;

	/**
	* @todo split long function
	* @todo error handling
	*/
	public function get_log_entries($orderBy, $orderDir, $filters)
	{
		$log_entries_query = DB::select('id')
			->from(DBlog::getTableName())
			->order_by($orderBy, $orderDir);
		$this->pagination = Pagination::factory(array
		(
			'total_items' => $log_entries_query->execute()->count(),
			'items_per_page' => 20,
			'auto_hide' => TRUE,
		));
		$logs = array();
		$log_entries_result = $log_entries_query
			->limit($this->pagination->items_per_page)
			->offset($this->pagination->offset)
			->execute()
			->as_array();
		foreach ($log_entries_result as $log)
		{
			$logs[] = Model_DBlog_Entry::factory($log['id']);
		}
		return $logs;
	}

	public function get_pagination()
	{
		if ($this->pagination)
			return $this->pagination;
		else
			return Pagination::factory();
	}

}