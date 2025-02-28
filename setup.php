<?php
// Incluir a conexão com o banco de dados
$conn = require_once 'db.php';

// SQL para criar a tabela
$sql_create = "
CREATE TABLE IF NOT EXISTS Chatbot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    keywords VARCHAR(255) NOT NULL,
    Chatbot TEXT NOT NULL
);
";

// SQL para inserir dados
$sql_insert = "
INSERT INTO Chatbot (keywords, Chatbot) 
VALUES 
    ('senha,recuperar,esqueci,alterar,mudar', 'Você pode recuperar ou alterar sua senha clicando em \"Esqueci minha senha\" na página de login do Moodle.'),
    ('acessar,entrar,login,logar', 'Para acessar o Moodle, acesse o site da sua instituição e faça login com seu usuário e senha.'),
    ('moodle,plataforma,sistema', 'O Moodle é uma plataforma de ensino à distância usada para cursos online.'),
    ('atividade,enviar,submeter,trabalho,tarefa', 'No Moodle, vá até a disciplina desejada, encontre a atividade, clique nela e siga as instruções.');
";

// Criar a tabela, se não existir
if ($conn->query($sql_create) === TRUE) {
    echo "Tabela 'Chatbot' criada com sucesso.\n";
} else {
    echo "Erro ao criar a tabela: " . $conn->error;
}

// Inserir dados, se necessário
if ($conn->query($sql_insert) === TRUE) {
    echo "Dados inseridos com sucesso.\n";
} else {
    echo "Erro ao inserir dados: " . $conn->error;
}

// Fechar a conexão
$conn->close();
?>
