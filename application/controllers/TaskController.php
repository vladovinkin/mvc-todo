<?php

namespace application\controllers;

use application\core\Controller;
use application\models\Task;

class TaskController extends Controller {

	public function createAction() {
		if (!empty($_POST)) {
			$this->model->taskCreate(trim($_POST["description"]));
			$this->view->location('/');
		}
		$this->view->render('Создание задачи');
	}

	public function updateAction() {
		
		if (!empty($_POST) && isset($_POST['description'])) {
			// сохранение
			$text = trim($_POST['description']);
			$this->model->setTaskText($this->route['id'], $text);
			$this->view->location('/');
		}

		if (isset($this->route['id'])) {
			$task_id = $this->route['id'];

			if ($this->model->isTaskExists($task_id)) {
				$text = $this->model->getTaskText($task_id);

				$vars = [
					'id' => $task_id,
					'text' => $text,
				];
					
				$this->view->render('Редактирование задачи', $vars);
				
			} else {
				$this->view->errorCode(404);
			}	
		} else {
			$this->view->errorCode(404);
		}
	}
}