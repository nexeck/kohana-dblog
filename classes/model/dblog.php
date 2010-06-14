<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
class Model_DBlog extends Model {

	protected $pagination;

	/**
	* @todo split long function
	* @todo error handling
	*/
	public function getLogEntries($orderBy, $orderDir, $filters) {
		$logEntriesQuery = DB::select('id')
			->from(DBlog::getTableName())
			->order_by($orderBy, $orderDir);
		$this->pagination = Pagination::factory(array(
			'total_items' => $logEntriesQuery->execute()->count(),
			'items_per_page' => 20,
			'auto_hide' => TRUE,
		));
		$logs = array();
		$logEntriesResult = $logEntriesQuery
			->limit($this->pagination->items_per_page)
			->offset($this->pagination->offset)
			->execute()
			->as_array();
		foreach ($logEntriesResult as $log) {
			$logs[] = Model_DBlog_Entry::factory($log['id']);
		}
		return $logs;
	}

	public function getPagination() {
		if ($this->pagination)
			return $this->pagination;
		else
			return Pagination::factory();
	}

}