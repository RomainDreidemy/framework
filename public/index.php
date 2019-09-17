<?php
session_start();
// Inclure l'autoloader généré par Composer
require __DIR__ . '/../vendor/autoload.php';

// Utilisation de notre class Router
use App\Router\Router;
use App\App\App;

// Penser a initialiser les informations de connexion à la base de données dans le fichier de configuration
$app = new App();
// $app->DB_Connect();

Router::parseRoute();