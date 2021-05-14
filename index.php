<?php
require_once 'controllers/Controller.php';
$controller = new Controller();

$visibility = $_GET['visibility'] ?? 'public';
$slug       = $_GET['slug'] ?? 'accueil';

$controller->displayView($visibility, $slug);
$controller->requireController($visibility, $slug);
