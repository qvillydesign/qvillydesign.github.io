<?php

namespace Inc\Utils;

use Inc\Base\BaseController;
use Inc\Database\DbImage;
use Inc\Database\DbUser;

/**
 * Class User
 *
 * @package Inc\Classes
 */
class User {

    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();


    /**
     * Init function run form the Init class every
     * time that we load a page.
     */
    public function register() {
        $this->editUser();
        $this->showError();
    }

    /**
     * Register a new user.
     *
     * @param string $userName     username
     * @param string $userEmail    email address
     * @param string $passwordHash password
     *
     * @return bool|int id of the row if everything right, false otherwise
     */
    public static function registerNewUser($userName, $userEmail, $passwordHash) {
        $data = array(
            "userName" => $userName,
            "userEmail" => $userEmail,
            "passwordHash" => $passwordHash,
            'dateRegistration' => DbUser::now()
        );
        return DbUser::insert($data);
    }

    /**
     * Get the current user logged.
     *
     * @return array|null
     */
    public static function getCurrentUser() {
        if (isset($_SESSION['userName'])) {
            return self::getBy($_SESSION['userName'], "username");
        } else {
            return false;
        }
    }

    /**
     * Understand if the user is admin or not.
     *
     * @return bool true if is admin, false if not
     */
    public static function isAdmin() {
        if ($user = self::getCurrentUser()) {
            return $user->isAdmin ? true : false;
        } else {
            return false;
        }
    }


    /**
     * Get user from username or email address.
     *
     * @param mixed  $id   id | username | email
     * @param string $type id | username | email
     *
     * @return array|object|null
     */
    public static function getBy($id, $type = "username") {
        if (!is_string($id)) return null;
        $data = null;

        if($type == "id"){
            $data = array("id" => $id);
        } else if ($type == "username") {
            $data = array("userName" => $id);
        } else if ($type == "email") {
            $data = array("userEmail" => $id);
        }

        $ret = DbUser::getSingle($data, "OBJECT");
        return $ret;
    }

    /**
     * Get the profile pic of a user.
     *
     * @param string $userName the username
     *
     * @return null|string the url of the img
     */
    public static function getProfilePic($userName) {
        $imageFinalPath = null;
        $baseController = new BaseController();
        $user = self::getBy($userName, $type = "username");

        if ($user && $user->idImage) {
            // get row from Image table
            $image = DbImage::getSingle(array("id" => $user->idImage), "OBJECT");
            if ($image) {
                $imageFinalPath = $baseController->website_url . $image->path;
            } else {
                $imageFinalPath = $baseController->website_url . "/assets/img/icon/default-avatar.png";
            }
        } else {
            $imageFinalPath = $baseController->website_url . "/assets/img/icon/default-avatar.png";
        }

        // Append a query string with an arbitrary unique number to
        // force the browser to refresh the image.
        $imageFinalPath .= "?" . rand(1, 500000000);

        return $imageFinalPath;
    }

    /**
     *  Remove image of a specific user.
     *
     * @param string $id   the username or email
     * @param string $type username | email
     *
     * @return bool true if success, false otherwise
     */
    public static function removeImage($id, $type = "username") {
        if (!is_string($id)) return false;
        $data = array("idImage" => null);

        $user = self::getBy($id, $type);

        $where = array('id' => $user->id);
        if (!(DbUser::update($data, $where))) {
            return false;
        }

        if (!(Image::removeById($user->idImage))) {
            return false;
        }

        return true;
    }

    /**
     * When clicked the button editLogin||removeImage  in edit-user.php
     * page the form send $_POST information and that function permit to
     * catch them.
     *
     * @return bool|false|int
     */
    public function editUser() {
        if (isset($_POST['editLogin'])) {

            $data = array(
                "firstName" => $_POST['firstName'],
                "lastName" => $_POST['lastName'],
            );

            // PASSWORD
            $userPassword = !empty($_POST['password']) ? $_POST['password'] : null;
            if ($userPassword) {

                $userPassword_hash = password_hash($userPassword, PASSWORD_DEFAULT);
                $data['passwordHash'] = $userPassword_hash;
            }

            // FILE
            if ($_FILES["uploadIcon"]['name']) {
                $idImage = Image::uploadProfile($_SESSION['userName'], $_FILES['uploadIcon']);
                $data['idImage'] = $idImage;
            }

            $this->messages[] = "Изменения сохранены.";

            return DbUser::update($data, ["userName" => $_SESSION['userName']]);
        } else if (isset($_POST["removeImage"])) {
            $this->messages[] = "Аватар удален.";

            return self::removeImage($_SESSION["userName"]);
        }
        // default
        return false;
    }

    /**
     * simply return the current state of the user's login
     *
     * @return boolean user's login status
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