<?php
require_once 'Util.php';
require_once 'controllers/Controller.php';
$controller = new Controller();

$id         = $_GET['id'] ?? null;
$visibility = $_GET['visibility'] ?  $_GET['visibility'] : 'public';
$slug       = $_GET['slug']       ?  $_GET['slug']       : 'accueil';

if ($controller->requireController($visibility, $slug))
    $controller = $controller->requireController($visibility, $slug);

try {
    $controller->displayView($visibility, $slug, $id);
} catch (Exception $e) {
    $controller = new Controller();
    $controller->displayView('public', '404');
}
