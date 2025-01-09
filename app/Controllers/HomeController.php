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

    public function buscarFuncionario() {
        $id = $_GET['id'] ?? null;
    
        if (!$id) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'ID do funcionário é obrigatório']);
            return;
        }
    
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM tbl_funcionario WHERE id_funcionario = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $funcionario = $stmt->fetch();
    
        if ($funcionario) {
            header('Content-Type: application/json');
            echo json_encode($funcionario);
        } else {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['error' => 'Funcionário não encontrado']);
        }
    }    
    
    public function editarFuncionario() {
        $id = $_POST['id_funcionario'] ?? null;
        $nome = $_POST['nome'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $rg = $_POST['rg'] ?? '';
        $email = $_POST['email'] ?? '';
        $id_empresa = $_POST['id_empresa'] ?? '';
        $salario = $_POST['salario'] ?? '';
        $data_cadastro = $_POST['data_cadastro'] ?? '';
    
        if (!$id || empty($nome) || empty($cpf) || empty($email) || empty($id_empresa) || empty($data_cadastro)) {
            echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
            return;
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'E-mail inválido.']);
            return;
        }
    
        try {
            $db = Database::connect();
            $stmt = $db->prepare("UPDATE tbl_funcionario 
                                  SET nome = :nome, cpf = :cpf, rg = :rg, email = :email, 
                                      id_empresa = :id_empresa, salario = :salario, data_cadastro = :data_cadastro 
                                  WHERE id_funcionario = :id");
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':cpf', $cpf);
            $stmt->bindValue(':rg', $rg);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':id_empresa', $id_empresa);
            $stmt->bindValue(':salario', $salario);
            $stmt->bindValue(':data_cadastro', $data_cadastro);
            $stmt->bindValue(':id', $id);
    
            $stmt->execute();
    
            echo json_encode(['success' => true, 'message' => 'Funcionário atualizado com sucesso.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar funcionário: ' . $e->getMessage()]);
        }
    }    
    
}
