<?php
require_once "../vendor/autoload.php";

use App\Controllers\LoginController;
use App\Controllers\HomeController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
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
} elseif ($uri === '/buscar-funcionario' && $method === 'GET') {
    (new HomeController())->buscarFuncionario();
} elseif ($uri === '/editar-funcionario' && $method === 'POST') {
    (new HomeController())->editarFuncionario();
} elseif ($uri === '/api/funcionarios' && $method === 'GET') {
    (new HomeController())->listarFuncionarios();
} else {
    header("HTTP/1.0 404 Not Found");
    echo "Página não encontrada!";
}
