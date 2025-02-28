<?php
session_start();  // Inicia a sessão
include('db.php'); // Incluir a conexão com o banco de dados

// Recebe a mensagem do usuário via POST
$message = strtolower(trim($_POST["message"] ?? ""));

// Verifica se o chat acabou de ser aberto
if (!isset($_SESSION["chat_started"])) {
    $_SESSION["chat_started"] = true;
    
    // Atraso proposital para simular comportamento humano
    usleep(1000000); // 1 segundo
    
    echo "Olá, eu sou Toinha! Como posso te ajudar hoje? Antes de começarmos, qual é o seu nome?";
    $_SESSION["waiting_for_name"] = true;
    exit;
}

// Verifica se está esperando o nome do usuário
if (isset($_SESSION["waiting_for_name"])) {
    $_SESSION["user_name"] = ucfirst($message);
    unset($_SESSION["waiting_for_name"]);
    
    // Atraso proposital para simular comportamento humano
    usleep(1500000); // 1.5 segundos
    
    echo "Prazer em te conhecer, {$_SESSION["user_name"]}! Como posso te ajudar?";
    exit;
}

$user_name = $_SESSION["user_name"] ?? "Usuário";

// Buscar resposta baseada em palavras-chave do banco de dados
$query = "SELECT * FROM respostas WHERE keywords LIKE ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", "%$message%");
$stmt->execute();
$result = $stmt->get_result();
$resposta = null;

if ($row = $result->fetch_assoc()) {
    $resposta = $row['resposta'];
}

// Se nenhuma resposta foi encontrada, usar resposta padrão
if ($resposta === null) {
    $_SESSION['erro_count']++;

    if ($_SESSION['erro_count'] == 1) {
        $resposta = "$user_name, desculpe, não encontrei uma resposta para isso. Reformule sua pergunta, por favor!";
    } elseif ($_SESSION['erro_count'] == 2) {
        $resposta = "$user_name, não consegui entender sua solicitação. Poderia reformular de outra maneira?";
    } else {
        $resposta = "$user_name, sinto muito, não consegui te entender. Encerrando o chat!";
        session_unset();
        session_destroy();
    }
}

// Atraso proposital para simular comportamento humano
usleep(rand(2000000, 4000000)); // Entre 2 e 4 segundos

echo $resposta;
?>
