<?php

namespace Blog\Controllers;

require_once 'Util.php';
require_once 'models/UserManager.php';

use \Blog\Models\UserManager;
use \Blog\Tools\Util;

class ControllerUser extends Controller
{
    private static $_instance;

    private function __construct()
    {
        if (isset($_POST) && !empty($_POST)) {
            $data = [
                'email'    => isset($_POST['email'])    ? filter_var($_POST['email'], FILTER_SANITIZE_STRING)    : '',
                'password' => isset($_POST['password']) ? filter_var($_POST['password'], FILTER_SANITIZE_STRING) : '',
            ];
            switch ($_POST['action']) {
                case 'register':
                    $data['first_name'] = isset($_POST['first_name']) ? filter_var($_POST['first_name'], FILTER_SANITIZE_STRING) : '';
                    $data['last_name']  = isset($_POST['last_name'])  ? filter_var($_POST['last_name'], FILTER_SANITIZE_STRING)  : '';
                    $data['birthdate']  = isset($_POST['birthdate'])  ? filter_var($_POST['birthdate'], FILTER_SANITIZE_STRING)  : '';

                    $json['alert'] = $this->register($data);
                    break;

                case 'login':
                    $json['alert'] = $this->login($data);
                    break;
            }
            if (isset($json)) {
                echo json_encode($json);
                // die;
            }
        } elseif ($_SERVER['REQUEST_URI'] == '/deconnexion/') {
            $this->logout();
        } 
    }

    /**
     * Singleton : returns instance of class.
     */
    public static function getInstance()
    {
        if (empty(self::$_instance))
            self::$_instance = new ControllerUser();

        return self::$_instance;
    }

    /**
     * Registers a user.
     * @param array $data
     * @return string
     */
    private function register($data)
    {
        $errors = [];
        $userManager = new UserManager();
        if (!Util::checkStrLen($data['first_name'], 3, 50)) $errors[] = 'Votre prénom doit être compris entre 3 et 50 caractères.';
        if (!Util::checkStrLen($data['last_name'], 3, 50))  $errors[] = 'Votre nom de famille doit être compris entre 3 et 50 caractères.';
        if (!Util::checkStrLen($data['email'], 0, 255))     $errors[] = 'Votre adresse e-mail 3 et 255 caractères.';
        if (!Util::checkPassword($data['password']))        $errors[] = 'Votre mot de passe doit contenir au minimum 8 caractères dont une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.';
        if (!Util::checkAge($data['birthdate']))            $errors[] = 'Vous devez être âgé(e) de 13 ans minimum afin de vous inscrire.';
        if (count($errors) == 0) {
            if ($userManager->insertUser($data))
                $this->storeInSession($userManager->getDB()->lastInsertId());
            else
                $errors[] = 'Une erreur est survenue, veuillez réessayer ou contacter un administrateur si le problème persiste.';
        }

        return Util::generateAlert($errors, '<script>document.location.href = "/";</script>');
    }

    /**
     * Logs in a user.
     * @param array $data
     * @return string
     */
    private function login($data)
    {
        $errors = [];
        $userManager = new UserManager();
        if ($data['email'] && $data['password']) {
            if (!$this->checkCredentials($data['email'], $data['password'])) $errors[] = 'Vos identifiants sont incorects, veuillez réessayer.';
            if (count($errors) == 0) {
                $this->storeInSession($this->getUser('email', $data['email'])['id']);
            }
        } else {
            $errors[] = "Veuillez remplir tous les champs.";
        }

        return Util::generateAlert($errors, '<script>document.location.href = "/";</script>');
    }

    /**
     * Checks if user is an admin.
     * @param int $id
     * @return bool
     */
    public function isAdmin($id)
    {
        return $this->getUser('id', $id)['type_id'] == 1;
    }

    /**
     * Logs out a user.
     * @return string
     */
    private function logout()
    {
        session_destroy();
        session_unset();
        header('Location: /');
    }

    /**
     * Checks user credentials.
     * @param string $email
     * @param string $password
     * @return bool
     */
    private function checkCredentials($email, $password)
    {
        $result = false;
        if ($user = $this->getUser('email', $email))
            $result = password_verify($password, $user['password']);

        return $result;
    }

    /**
     * Returns user data.
     * @param string $column
     * @param mixed  $value
     * @return mixed
     */
    public function getUser($column, $value)
    {
        $userManager = new UserManager();
        return $userManager->selectUser($column, $value);
    }

    /**
     * Stores user ID in session.
     * @param int $id User ID
     */
    private function storeInSession($id)
    {
        $_SESSION['user_id'] = $id;
    }
}
