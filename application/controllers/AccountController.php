<?php

namespace application\controllers;

use application\core\Controller;
use application\models\Account;

class AccountController extends Controller {

	public function loginAction() {
		if (!empty($_POST)) {
			$user_id = $this->model->getUserId(trim($_POST["login"]), trim($_POST["password"]));
			if ($user_id) {
				$this->model->authStart(trim($_POST["login"]), $user_id);
				$this->view->location('/');
			} else {
				$this->model->authStop();
				$this->view->message('Ошибка авторизации', 'Неверные логин и/или пароль');
			}
		}
		$this->view->render('Вход');
	}

	public function registerAction() {
		if (!empty($_POST)) {
			if ($this->emptyFields([
				trim($_POST["login"]),
				trim($_POST["password"]),
				trim($_POST["name"]),
				trim($_POST["surname"]),
				trim($_POST["email"]),
			])) {
				$this->view->message('Ошибка регистрации', 'Все поля обязательны к заполнению');
			} else if ($this->model->getUserExists(trim($_POST["login"]))) {
				$this->view->message('Ошибка регистрации', 'Такой пользователь уже есть в системе');
			}
			else {
				$this->model->addNewUser(trim($_POST["login"]), trim($_POST["password"]), trim($_POST["name"]), trim($_POST["surname"]), trim($_POST["email"]));
				$user_id = $this->model->getUserId(trim($_POST["login"]), trim($_POST["password"]));
				$this->model->authStart(trim($_POST["login"]), $user_id);
				$this->view->location('/');
			}
		}
		$this->view->render('Регистрация');
	}
	
	public function logoutAction() {
		$this->model->authStop();
		sleep(1);
		header("Location: /"); 
	}

	// проверяет массив на пустое значение хотя бы одного элемента
	public function emptyFields($arr) {
		if (is_array($arr) && count($arr)) {
			$mult = 1;
			foreach ($arr as $elem) {
				$mult = $mult * strlen($elem);
			}
			return $mult == 0;
		}
		return true;
	}
}