<?php

namespace application\controllers;

use application\core\Controller;
use application\models\Account;
use application\lib\Pagination;


class MainController extends Controller {

	public function indexAction() {
		$pagination = new Pagination($this->route, $this->model->tasksCount($this->model->getId()), 5);
		$result = $this->model->getTasks((isset($this->route['page']) ? $this->route['page'] : 1), $pagination->getLimit());
		$vars = [
			'tasks' => $result,
			'is_authorized' => Account::isAuth(),
			'pagination' => $pagination->get(),
		];
		$this->view->render('Главная страница', $vars);
	}
}