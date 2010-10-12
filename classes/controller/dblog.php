<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * @package    dblog
 * @author     Bastian Bräu
 */
class Controller_DBlog extends Controller
{

	public function before()
	{
		$this->deny_direct_access();
		parent::before();
		if (isset($_GET['log_id']))
		{
			$this->request->action = 'show';
		}
	}

	public function action_index()
	{
		$logs = ORM::factory('log');
		$counter = clone $logs;
		$pagination = Pagination::factory(array(
			'current_page'   => array('source' => 'query_string', 'key' => 'page'),
			'total_items'    => $counter->count_all(),
			'items_per_page' => 20,
			'view'           => 'pagination/floating',
			'auto_hide'      => TRUE,
		));
		$logs = $logs
			->order_by('tstamp', 'DESC')
			->limit($pagination->items_per_page)
			->offset($pagination->offset)
			->find_all()
			->as_array();
		$view = View::factory('dblog/index')
			->bind('logs', $logs)
			->set('pagination', $pagination);
		$this->request->response = $view;
	}

	public function action_show()
	{
		$this->request->response = View::factory('dblog/show')
			->set('log', ORM::factory('log', (int) $_GET['log_id']));
	}

	protected function deny_direct_access()
	{
		if ($this->request === Request::$instance)
		{
			throw new DBlog_Exception('No direct access allowed');
		}
	}

}