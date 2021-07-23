<?php

session_start();

require_once 'Util.php';
require_once 'controllers/Controller.php';
require_once 'controllers/ControllerUser.php';

// Controllers.
$mainController = new Controller();
$controllerUser = new ControllerUser();

// User data.
$curUser = $controllerUser->getUser('id', $_SESSION['user_id'] ?? null);

// Query strings
$id         = $_GET['id']         ?? null;
$visibility = $_GET['visibility'] ?? 'public';
$slug       = $_GET['slug']       ?? 'accueil';

if ($visibility == 'public' && $slug == 'admin') {
    if ($controllerUser->isAdmin($curUser['id'])) {
        $visibility = 'admin';
        $slug       = 'accueil';
    }
}

if ($pageController = $mainController->requireController($visibility, $slug))
    $mainController = $pageController;

try {
    if (empty($_POST)) {
        $mainController->displayView($visibility, $slug, $id);
        // Debug mode
        // var_dump($slug);
        // var_dump($visibility);
        // var_dump($id);
        // var_dump(get_class($mainController));
        // var_dump($curUser);
    }
} catch (Exception $e) {
    $mainController = new Controller();
    $mainController->displayView($visibility, '404');
}
