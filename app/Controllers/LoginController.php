<?php
namespace App\Controllers;

use App\Models\Database;

class LoginController {
    public function showLoginForm() {
        require_once "../app/Views/login.php";
    }

    public function authenticate() {
        $data = json_decode(file_get_contents("php://input"), true);
    
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Formato de email inválido.']);
            return;
        }
    
        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
            return;
        }
    
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM tbl_usuario WHERE login = :email AND senha = :senha");
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', md5($password));
        $stmt->execute();
    
        $user = $stmt->fetch();
    
        if ($user) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Email ou senha incorretos.']);
        }
    }    
}
