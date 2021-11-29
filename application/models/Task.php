<?php

namespace application\models;

use application\core\Model;

class Task extends Model {
	
	public function taskCreate($task) {
		$user_id = $this->getId();
		if ($user_id) {
			$stmt = $this->db->query('INSERT INTO tasks (user_id, text) VALUES (:user_id, :text)', [
				'user_id' => $user_id,
				'text' => $task,
			]);
		}
		return true;
	}

	public function setTaskText($task_id, $task) {
		$user_id = $this->getId();
		$stmt = $this->db->query('UPDATE tasks SET text = :text WHERE (id = :id AND user_id = :user_id)', [
			'id' => $task_id,
			'text' => $task,
			'user_id' => $user_id,
		]);
		return true;
	}

	public function getTaskText($task_id) {
		$user_id = $this->getId();
		$result = $this->db->row('SELECT id, user_id, text FROM tasks WHERE (id = :id AND user_id = :user_id)', [
			'id' => $task_id,
			'user_id' => $user_id,
		]);
		return (
			count($result)
			? $result[0]['text'] 
			: false
		);
	}

	public function isTaskExists($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT id FROM tasks WHERE id = :id', $params);
	}

	/**
     * Метод возвращает id авторизованного пользователя 
     */
    public function getId() {
        if ($this->isAuth()) { //Если пользователь авторизован
            return $_SESSION['authorize']['id']; //Возвращаем id, который записан в сессию
        }
		return false;
    }
       
    public function out() {
        $_SESSION = array(); //Очищаем сессию
        session_destroy(); //Уничтожаем
		return true;
    }

	/**
     * Проверяет, авторизован пользователь или нет
     * Возвращает true если авторизован, иначе false
     * @return boolean 
     */
    public static function isAuth() {
        return (isset($_SESSION['authorize']['login']) && isset($_SESSION['authorize']['id']));
    }
}