<?php
// Defina suas credenciais de banco de dados
$servername = "localhost";
$username = "root"; // Altere para seu nome de usuário
$password = ""; // Altere para sua senha
$dbname = "Chatbot"; // Nome do banco de dados

// Criação da conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
