<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Kohana/dblog
 * @author     Bastian Bräu
 */
class Controller_DBlog extends Controller {

	protected $model;

	public function __construct($request) {
		parent::__construct($request);
		$this->model = Model::factory('DBlog');
	}

	public function action_index() {
		$this->request->response = $this->getIndexView(
			$this->model,
			$this->model->getAllLogEntries()
		);
	}

	protected function getIndexView(Model_DBlog $model, array $logs) {
		return View::factory('dblog/index', array(
			'model' => $model,
			'logs' => $logs,
		));
	}

}