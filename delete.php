<?php
// Incluir o arquivo de conexão com o banco de dados
$conn = require_once 'db.php';

// Verificar se o ID foi passado
$id = $_GET['id'] ?? null;

if ($id) {
    // Deletar a palavra-chave e resposta com o ID fornecido
    $stmt = $conn->prepare("DELETE FROM respostas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header('Location: admin.php');
exit;
