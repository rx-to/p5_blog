<?php
require_once 'controllers/Controller.php';
$controller = new Controller();

if (isset($_GET['controller']))
    $controller->displayView($_GET['controller']);
else
    throw new Exception("Le contrôleur n'existe pas.");
