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
		
		if (!empty($_POST)) {
			$task_id = $_POST['id'];
			
			if (isset($_POST['text'])) { // сохранение
				$text = trim($_POST['text']);
				$this->model->setTaskText($task_id, $text);
				$this->view->location('/');
				
			} else { // нажали изменить в списке задач - переход в форму редактирования
				$text = $this->model->getTaskText($task_id);
				
				if ($text) {
					$this->view->message('Проверка', $text . ':' . $task_id);
					// $vars = [
						// 	'id' => $task_id,
						// 	'text' => $text,
						// ];
						
					$this->view->render('Редактирование задачи');
				}

			}




			// $this->view->message('Ошибка авторизации', 'Неверные логин и/или пароль');
			// $this->view->message('test-debug', $_POST['login']);
			// $this->view->message('id = ', $_POST['id']);

			// $this->model->taskCreate(trim($_POST["description"]));
			// $this->view->location('/');
		}
		View::errorCode(403);
	}
}