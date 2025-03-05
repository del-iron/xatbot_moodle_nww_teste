<?php
$conn = require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keywords = $_POST['keywords'];
    $chatbot_response = $_POST['chatbot'];

    $stmt = $conn->prepare("INSERT INTO Chatbot (keywords, Chatbot) VALUES (?, ?)");
    $stmt->bind_param("ss", $keywords, $chatbot_response);

    if ($stmt->execute()) {
        echo "Novo registro adicionado!";
    } else {
        echo "Erro ao inserir: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
