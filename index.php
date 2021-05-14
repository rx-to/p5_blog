<?php
require_once 'controllers/Controller.php';
$controller = new Controller();

if (isset($_GET['part']) && isset($_GET['page'])) {
    $controller->displayView($_GET['part'], $_GET['page']);
    $controller->requireController($_GET['page']);
} else {
    $controller->displayView('public', 'home');
}