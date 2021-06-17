<?php
require_once 'Util.php';
require_once 'controllers/Controller.php';
$controller = new Controller();

$id         = $_GET['id'] ?? null;
$visibility = $_GET['visibility'] ?? 'public';
$slug       = $_GET['slug']       ?? 'accueil';

if ($controller2 = $controller->requireController($visibility, $slug))
    $controller = $controller2;

// Debug
// var_dump($slug);
// var_dump($visibility);
// var_dump($id);
// var_dump(get_class($controller));
try {
    if (empty($_POST))
        $controller->displayView($visibility, $slug, $id);
} catch (Exception $e) {
    $controller = new Controller();
    $controller->displayView('public', '404');
}
