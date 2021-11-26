<?php

namespace application\controllers;

use application\core\Controller;
use application\models\Account;

class MainController extends Controller {

	public function indexAction() {
		$result = $this->model->getTasks();
		$vars = [
			'tasks' => $result,
			'is_authorized' => Account::isAuth(),
		];
		$this->view->render('Главная страница', $vars);
	}
}