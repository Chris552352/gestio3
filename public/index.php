<?php
require_once __DIR__ . "/../vendor/autoload.php";

// Démarrer la session
session_start();

// Charger les configurations
require_once __DIR__ . "/../config/config.php";

// Router
$router = new App\Core\Router();
$router->dispatch();
