<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
class Controller_DBlog extends Controller {

	protected $model;
	protected $requestedLogId;

	public function __construct($request) {
		parent::__construct($request);
		$this->model = Model::factory('DBlog');
	}

	public function before() {
		$this->redirectIfLogIdPresent();
	}

	public function redirectIfLogIdPresent() {
		if (isset($_GET['log_id'])) {
			$this->requestedLogId = (int) $_GET['log_id'];
			if ($this->requestedLogId > 0) {
				$this->request->action = 'show';
			}
		}
	}

	public function action_index() {
		$this->request->response = $this->getIndexView(
			$this->model,
			$this->model->getFormattedLogs()
		);
	}

	protected function getIndexView(Model_DBlog $model, array $logs) {
		return View::factory('dblog/index', array(
			'model' => $model,
			'logs' => $logs,
		));
	}

	public function action_show() {
		$this->request->response = $this->getShowView(
			$this->model,
			$this->model->getSingleLog($this->requestedLogId)
		);
	}

	protected function getShowView(Model_DBlog $model, array $log) {
		return View::factory('dblog/show', array(
			'model' => $model,
			'log' => $log,
		));
	}

}