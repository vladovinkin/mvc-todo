<?php

namespace application\models;

use application\core\Model;

class Account extends Model {
	
	// добавление нового пользователя в базу
	public function addNewUser($login, $password, $name, $surname, $email) {
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$stmt = $this->db->query('INSERT INTO users (login, hash, name, surname, email) VALUES (:login, :hash, :name, :surname, :email)', [
			'login' => $login,
			'hash' => $hash,
			'name' => $name,
			'surname' => $surname,
			'email' => $email,
		]);
		return true;
	}

	// возвращает наличие пользователя в базе
	public function getUserExists($login) {
		$result = $this->db->row('SELECT name  FROM users WHERE login = :login', ['login' => $login]);
		return count($result) === 1;
	}

	// возвращает id пользователя в случае верной пары логин/пароль, иначе - false
	public function getUserID($login, $password) {
		$result = $this->db->row('SELECT id, login, hash FROM users WHERE login = :login', ['login' => $login]);
		return (
			count($result) && password_verify($password, $result[0]['hash'])
			? $result[0]['id'] 
			: false
		);
	}

	public function authStart($login, $id) {
        $_SESSION['authorize']['login'] = $login; 
        $_SESSION['authorize']['id'] = $id;
		return true;
    }

    public static function authStop() {
        unset($_SESSION['authorize']);
		return true;
    }

	/**
     * Метод возвращает логин авторизованного пользователя 
     */
    public function getLogin() {
        if ($this->isAuth()) { //Если пользователь авторизован
            return $_SESSION['authorize']['login']; //Возвращаем логин, который записан в сессию
        }
    }

	/**
     * Метод возвращает id авторизованного пользователя 
     */
    public function getId() {
        if ($this->isAuth()) { //Если пользователь авторизован
            return $_SESSION['authorize']['id']; //Возвращаем id, который записан в сессию
        }
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