<?php
require_once "vendor/autoload.php";

use App\Models\Database;

try {
    $db = Database::connect();
    echo "Conexão com o banco realizada com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao conectar: " . $e->getMessage();
}
