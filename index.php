<?php

session_start();

require_once 'Util.php';
require_once 'controllers/Controller.php';
require_once 'controllers/ControllerUser.php';

use Blog\Controllers\Controller;
use Blog\Controllers\ControllerUser;

// Query strings
$id         = $_GET['id']         ?? null;
$visibility = $_GET['visibility'] ?? 'public';
$slug       = $_GET['slug']       ?? 'accueil';

// Controllers.
$mainController = new Controller($visibility, $slug);
$controllerUser = ControllerUser::getInstance();

// User data.
$curUser = $controllerUser->getUser('id', $_SESSION['user_id'] ?? null);

if ($visibility == 'public' && $slug == 'admin') {
    if ($curUser && $controllerUser->isAdmin($curUser['id'])) {
        $visibility = 'admin';
        $slug       = 'accueil';
    }
}

if ($pageController = $mainController->requireController())
    $mainController = $pageController;

try {
    if (empty($_POST)) {
        $mainController->displayView($visibility, $slug, $id);
    }
} catch (Exception $e) {
    $mainController = new Controller($visibility, '404');
    $mainController->displayView($visibility, '404');
}
