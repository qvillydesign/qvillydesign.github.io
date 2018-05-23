<?php

namespace Inc\Utils;

use Inc\Database\Db;
use Inc\Database\DbUser;

/**
 * Handles the user registration
 *
 * @package Inc\Classes
 */
class Registration {
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * Init function run form the Init class every
     * time that we load a page.
     */
    public function register() {
        if (session_status() == PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }

        if (isset($_POST["register"])) {
            if ($this->registerNewUser()) {
                $login = new Login();
                $login->doLogin($_POST['userName'], $_POST['userPasswordNew']);
            } else {
                $this->showError();
            }
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     *
     * @return bool true if success, false otherwise
     */
    private function registerNewUser() {
        if (empty($_POST['userName'])) {
            $this->errors[] = "Пустое имя пользователя";
        } elseif (empty($_POST['userPasswordNew']) || empty($_POST['userPassword_repeat'])) {
            $this->errors[] = "Пустой пароль";
        } elseif ($_POST['userPasswordNew'] !== $_POST['userPassword_repeat']) {
            $this->errors[] = "Пароль не соответствует";
        } elseif (strlen($_POST['userPasswordNew']) < 6) {
            $this->errors[] = "Пароль имеет минимальную длину 6 символов";
        } elseif (strlen($_POST['userName']) > 64 || strlen($_POST['userName']) < 2) {
            $this->errors[] = "Имя пользователя не может быть короче 2 или более 64 символов";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['userName'])) {
            $this->errors[] = "Имя пользователя не соответствует схеме имен: разрешены только A-Z, от 2 до 64 символов";
        } elseif (empty($_POST['userEmail'])) {
            $this->errors[] = "Электронная почта не может быть пуста";
        } elseif (strlen($_POST['userEmail']) > 64) {
            $this->errors[] = "Электронная почта не может быть длиннее 64 символов";
        } elseif (!filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Ваш адрес электронной почты не в действительном формате";
        } elseif (!empty($_POST['userName'])
            && strlen($_POST['userName']) <= 64
            && strlen($_POST['userName']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['userName'])
            && !empty($_POST['userEmail'])
            && strlen($_POST['userEmail']) <= 64
            && filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['userPasswordNew'])
            && !empty($_POST['userPassword_repeat'])
            && ($_POST['userPasswordNew'] === $_POST['userPassword_repeat'])
        ) {
            // create a database connection
            $this->db_connection = new \mysqli(Db::HOST, Db::USER, Db::PASS, Db::NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $userName = $this->db_connection->real_escape_string(strip_tags($_POST['userName'], ENT_QUOTES));
                $userEmail = $this->db_connection->real_escape_string(strip_tags($_POST['userEmail'], ENT_QUOTES));

                $userPassword = $_POST['userPasswordNew'];

                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
                $userPassword_hash = password_hash($userPassword, PASSWORD_DEFAULT);

                // check if user or email address already exists
                if (User::getBy($userName, "username") || User::getBy($userEmail, "email")) {
                    $this->errors[] = "Извините, это имя пользователя / адрес электронной почты уже испоьзуется.";
                } else {
                    // write new user's data into database
                    $insertResponse = User::registerNewUser($userName, $userEmail, $userPassword_hash);

                    // if user has been added successfully
                    if ($insertResponse) {
                        $this->messages[] = "Ваша учетная запись создана успешно. Теперь вы можете войти в систему.";
                        return true;
                    } else {
                        $this->errors[] = "Извините, ваша регистрация не удалась. Пожалуйста вернитесь и попробуйте снова.";
                    }
                }
            } else {
                $this->errors[] = "К сожалению, подключение к базе данных отсутствует.";
            }
        } else {
            $this->errors[] = "Произошла неизвестная ошибка.";
        }

        //default return;
        return false;
    }

    /**
     * Simply return the current state of the user's login
     */
    public function showError() {
        if ($this->errors) { ?>
            <div class="message alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php
                foreach ($this->errors as $error) {
                    echo $error;
                }
                ?>
            </div>
            <?php
        }
        if ($this->messages) { ?>
            <div class="message alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php
                foreach ($this->messages as $message) {
                    echo $message;
                }
                ?>
            </div>
            <?php
        }
    }
}
