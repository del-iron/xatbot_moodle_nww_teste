<?php
// Incluir o arquivo de conexão com o banco de dados
$conn = require_once 'db.php';

// Verificar se o formulário foi enviado para adicionar uma nova palavra-chave e resposta
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keywords = trim($_POST['keywords']);
    $resposta = trim($_POST['resposta']);

    if (!empty($keywords) && !empty($resposta)) {
        // Inserir no banco de dados
        $stmt = $conn->prepare("INSERT INTO respostas (keywords, resposta) VALUES (?, ?)");
        $stmt->bind_param("ss", $keywords, $resposta);

        if ($stmt->execute()) {
            $message = "Palavra-chave e resposta adicionadas com sucesso!";
        } else {
            $message = "Erro ao adicionar a palavra-chave e resposta!";
        }
        $stmt->close();
    } else {
        $message = "Por favor, preencha todos os campos!";
    }
}

// Recuperar todas as palavras-chave e respostas para exibir na interface administrativa
$result = $conn->query("SELECT * FROM respostas");

// Fechar a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Administrativa - Chatbot</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Administração de Palavras-Chave e Respostas</h1>

    <!-- Exibir mensagens -->
    <?php if (isset($message)): ?>
        <p><strong><?php echo $message; ?></strong></p>
    <?php endif; ?>

    <!-- Formulário para adicionar palavras-chave e respostas -->
    <form action="admin.php" method="POST">
        <label for="keywords">Palavras-chave (separadas por vírgula):</label>
        <input type="text" id="keywords" name="keywords" required>

        <label for="resposta">Resposta:</label>
        <textarea id="resposta" name="resposta" required></textarea>

        <button type="submit">Adicionar</button>
    </form>

    <h2>Palavras-chave e Respostas Cadastradas</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Palavras-chave</th>
                <th>Resposta</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['keywords']; ?></td>
                    <td><?php echo $row['resposta']; ?></td>
                    <td>
                        <!-- Botões para Editar e Deletar -->
                        <a href="edit.php?id=<?php echo $row['id']; ?>">Editar</a> |
                        <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
