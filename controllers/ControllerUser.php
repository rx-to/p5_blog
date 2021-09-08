<?php

namespace Blog\Controllers;

require_once 'Util.php';
require_once 'models/UserManager.php';

use \Blog\Models\UserManager;
use \Blog\Tools\Util;

class controllerUser extends Controller
{
    public function __construct()
    {
        if (!empty($_POST)) {
            switch ($_POST['action']) {
                case 'register':
                    $json['alert'] = $this->register($_POST);
                    break;

                case 'login':
                    $json['alert'] = $this->login($_POST);
                    break;
            }
            if (isset($json)) {
                echo json_encode($json);
                die;
            }
        } elseif ($_SERVER['REQUEST_URI'] == '/deconnexion/') {
            $this->logout();
        } elseif ($_SERVER['REQUEST_URI'] == '/connexion/') {
            if (isset($_SESSION['user_id']))
                header('Location: /');
        }
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
