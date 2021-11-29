<?php

namespace application\models;

use application\core\Model;

class Main extends Model {

	public function getTasks($page = 1, $pagination_limit = 10) {
		$user_id = $this->getId();
		$start = ($page - 1) * $pagination_limit;
		$params = [
			'user_id' => $user_id,
			'start' => $start,
			'max' => $pagination_limit,
		];
		if ($user_id) {
			$result = $this->db->row('SELECT * FROM tasks WHERE user_id = :user_id ORDER BY id DESC LIMIT :start, :max', $params);
			return $result;
		}
		return [];
	}

	public function tasksCount($user_id) {
		return $this->db->column('SELECT COUNT(id) FROM tasks WHERE user_id = :user_id', ['user_id' => $user_id]);
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

	/**
     * Проверяет, авторизован пользователь или нет
     * Возвращает true если авторизован, иначе false
     * @return boolean 
     */
    public static function isAuth() {
        return (isset($_SESSION['authorize']['login']) && isset($_SESSION['authorize']['id']));
    }
}