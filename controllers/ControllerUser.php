<?php

require_once 'models/UserManager.php';

class controllerUser extends Controller
{
    function __construct()
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
            echo json_encode($json);
        }
    }

    /**
     * Registers a user.
     * @param array $data
     * @return string
     */
    function register($data)
    {
        $errors = [];
        $userManager = new UserManager();
        if (!Util::checkStrLen($data['first_name'], 3, 50)) $errors[] = 'Votre prénom doit être compris entre 3 et 50 caractères.';
        if (!Util::checkStrLen($data['last_name'], 3, 50))  $errors[] = 'Votre nom de famille doit être compris entre 3 et 50 caractères.';
        if (!Util::checkStrLen($data['email'], 0, 255))     $errors[] = 'Votre adresse e-mail 3 et 255 caractères.';
        if (!Util::checkPassword($data['password']))        $errors[] = 'Votre mot de passe doit contenir au minimum 8 caractères dont une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.';
        if (!Util::checkAge($data['birthdate']))            $errors[] = 'Vous devez être âgé(e) de 13 ans minimum afin de vous inscrire.';
        if (count($errors) == 0)
            if (!$userManager->insertUser($data)) $errors[] = 'Une erreur est survenue, veuillez réessayer ou contacter un administrateur si le problème persiste.';
        
        return count($errors) > 0 ? $this->generateAlert($errors, null) : $this->storeInSession($userManager->getDB()->lastInsertId());
    }

    /**
     * Stores user ID in session.
     * @param int $id User ID
     */
    function storeInSession($id) {
        $_SESSION['user_id'] = $id;
    }

    

}
