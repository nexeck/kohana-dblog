<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
class Controller_DBlog extends Controller
{

	protected $model;
	protected $requested_log_id;

	public function before()
	{
		$this->redirect_if_log_id_present();
		$this->deny_direct_access();
	}

	protected function redirect_if_log_id_present()
	{
		if (isset($_GET['log_id']))
		{
			$this->requested_log_id = (int) $_GET['log_id'];
			if ($this->requested_log_id > 0)
				$this->request->action = 'show';
		}
	}

	/**
	* @todo clean up
	* @todo implement sorting and filtering
	*/
	public function action_index()
	{
		$model = Model::factory('DBlog');
		$orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'tstamp';
		$orderDir = 'DESC';
		if (isset($_GET['order_dir']) AND (strtoupper($_GET['order_dir']) != 'DESC'))
			$orderDir = 'ASC';
		$filters = array();
		$this->request->response = View::factory('dblog/index', array
		(
			'orders' => Model::factory('DBlog_Order'),
			'logs' => $model->get_log_entries($orderBy, $orderDir, $filters),
			'pagination' => $model->get_pagination(), // Passing $pagination->render() to the view will lead to wrong urls!
		));
	}

	public function action_show()
	{
		$this->request->response = View::factory('dblog/show', array
		(
			'log' => Model_DBlog_Entry::factory($this->requested_log_id),
		));
	}

	protected function deny_direct_access()
	{
		if ($this->request === Request::$instance)
			throw new DBlog_Exception('No direct access allowed');
	}

}