<?php
require_once 'controllers/Controller.php';
$controller = new Controller();

$visibility = $_GET['visibility'] ? $_GET['visibility']: 'public';
$slug       = $_GET['slug'] ? $_GET['slug']: 'accueil';

var_dump($visibility);
var_dump($slug);

$controller->requireController($visibility, $slug);
$controller->displayView($visibility, $slug);
