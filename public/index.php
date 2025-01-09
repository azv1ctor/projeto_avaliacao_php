<?php
require_once "../vendor/autoload.php";

use App\Controllers\LoginController;
use App\Controllers\HomeController;

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/login' && $method === 'GET') {
    (new LoginController())->showLoginForm();
} elseif ($uri === '/login' && $method === 'POST') {
    (new LoginController())->authenticate();
} elseif ($uri === '/home' && $method === 'GET') {
    (new HomeController())->index();
} elseif ($uri === '/excluir-funcionario' && $method === 'GET') {
    (new HomeController())->delete();
} elseif ($uri === '/adicionar-funcionario' && $method === 'POST') {
    (new HomeController())->addFuncionario();
} elseif ($uri === '/adicionar-empresa' && $method === 'POST') {
    (new HomeController())->addEmpresa();
} elseif ($uri === '/cadastro-funcionario' && $method === 'GET') {
    (new HomeController())->cadastroFuncionario();
} elseif ($uri === '/cadastro-empresa' && $method === 'GET') {
    (new HomeController())->cadastroEmpresa();
} else {
    header("HTTP/1.0 404 Not Found");
    echo "Página não encontrada!";
}
