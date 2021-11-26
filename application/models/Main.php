<?php

namespace application\models;

use application\core\Model;

class Main extends Model {

	public function getTasks() {
		$user_id = $this->getId();
		if ($user_id) {
			$result = $this->db->row('SELECT id, user_id, text FROM tasks WHERE user_id = ' . $user_id . ' ORDER BY id DESC');
			return $result;
		}
		return [];
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