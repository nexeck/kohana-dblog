<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
class Controller_DBlog extends Controller {

	protected $model;
	protected $requestedLogId;

	public function before() {
		$this->redirectIfLogIdPresent();
		$this->denyDirectAccess();
	}

	protected function redirectIfLogIdPresent() {
		if (isset($_GET['log_id'])) {
			$this->requestedLogId = (int) $_GET['log_id'];
			if ($this->requestedLogId > 0)
				$this->request->action = 'show';
		}
	}

	/**
	* @todo clean up!
	* @todo implement sorting and filtering
	*/
	public function action_index() {
		$logEntriesQuery = DB::select('id')
			->from(DBlog::getTableName())
			->order_by('tstamp', 'DESC');
		$pagination = Pagination::factory(array(
			'total_items' => $logEntriesQuery->execute()->count(),
			'items_per_page' => 20,
			'auto_hide' => TRUE,
		));
		$logs = array();
		$logEntriesResult = $logEntriesQuery
			->limit($pagination->items_per_page)
			->offset($pagination->offset)
			->execute()
			->as_array();
		foreach ($logEntriesResult as $log) {
			$logs[] = Model_DBlog_Entry::factory($log['id']);
		}
// 		strtr($pagination->render(), array(
// 			Request::current()->uri => Request::$instance->uri,
// 		));
		$this->request->response = View::factory('dblog/index', array(
			'pagination' => $pagination, // Passing $pagination->render() to the view will lead to wrong urls!
										 // Why does this even work? Just echoing the Pagination object in the view!
			'logs' => $logs,
		));
	}

	public function action_show() {
		$this->request->response = View::factory('dblog/show', array(
			'log' => Model_DBlog_Entry::factory($this->requestedLogId),
		));
	}

	protected function denyDirectAccess() {
		if ($this->request === Request::$instance)
			$this->request->action = 'block';
	}

	public function action_block() {
		DBlog::add('info', 'DBlog: Blocked direct request.', 'Full URL: '.URL::base().getenv('REQUEST_URI'));
		$this->request->status = 403;
		$this->request->response = '403 Forbidden';
	}

}