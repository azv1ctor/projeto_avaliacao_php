<?php
namespace App\Controllers;

use App\Models\Database;

class HomeController {
    public function index() {
        $db = Database::connect();
        $stmt = $db->query("SELECT f.*, e.nome AS empresa_nome 
                            FROM tbl_funcionario f
                            LEFT JOIN tbl_empresa e ON f.id_empresa = e.id_empresa");
        $funcionarios = $stmt->fetchAll();

        $stmtEmpresas = $db->query("SELECT * FROM tbl_empresa");
        $empresas = $stmtEmpresas->fetchAll();

        require_once "../app/Views/home.php";
    }

    public function delete() {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $db = Database::connect();
            $stmt = $db->prepare("DELETE FROM tbl_funcionario WHERE id_funcionario = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        }

        header("Location: /home");
        exit;
    }

    public function addFuncionario() {
        $nome = $_POST['nome'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $rg = $_POST['rg'] ?? '';
        $email = $_POST['email'] ?? '';
        $id_empresa = $_POST['id_empresa'] ?? '';
        $salario = $_POST['salario'] ?? '';
        $data_cadastro = $_POST['data_cadastro'] ?? date('Y-m-d');
    
        $errors = [];
    
        if (empty($nome) || empty($cpf) || empty($email) || empty($id_empresa)) {
            $errors[] = "Todos os campos obrigatórios devem ser preenchidos.";
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Formato de email inválido.";
        }
    
        if (empty($errors)) {
            $db = Database::connect();
            $stmt = $db->prepare("INSERT INTO tbl_funcionario (nome, cpf, rg, email, id_empresa, salario, data_cadastro) 
                                  VALUES (:nome, :cpf, :rg, :email, :id_empresa, :salario, :data_cadastro)");
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':cpf', $cpf);
            $stmt->bindValue(':rg', $rg);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':id_empresa', $id_empresa);
            $stmt->bindValue(':salario', $salario);
            $stmt->bindValue(':data_cadastro', $data_cadastro);
            $stmt->execute();
        }
    
        header("Location: /home");
        exit;
    }    

    public function addEmpresa() {
        $nome = $_POST['nome'] ?? '';

        if (!empty($nome)) {
            $db = Database::connect();
            $stmt = $db->prepare("INSERT INTO tbl_empresa (nome) VALUES (:nome)");
            $stmt->bindValue(':nome', $nome);
            $stmt->execute();
        }

        header("Location: /home");
        exit;
    }

    public function cadastroFuncionario() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM tbl_empresa");
        $empresas = $stmt->fetchAll();

        require_once "../app/Views/funcionario.php";
    }

    public function cadastroEmpresa() {
        require_once "../app/Views/empresa.php";
    }
}
