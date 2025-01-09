<?php
require_once "../vendor/autoload.php";

use App\Controllers\LoginController;

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/login' && $method === 'GET') {
    (new LoginController())->showLoginForm();
} elseif ($uri === '/login' && $method === 'POST') {
    (new LoginController())->authenticate();
} else {
    echo "Página não encontrada!";
}
