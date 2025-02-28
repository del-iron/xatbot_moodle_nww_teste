<?php
// Incluir a conexão com o banco de dados
$conn = require_once 'db.php';

// Verificar se o ID foi passado
$id = $_GET['id'] ?? null;

if ($id) {
    // Recuperar a palavra-chave e resposta com o ID fornecido
    $stmt = $conn->prepare("SELECT * FROM respostas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $keywords = trim($_POST['keywords']);
        $resposta = trim($_POST['resposta']);

        if (!empty($keywords) && !empty($resposta)) {
            // Atualizar o banco de dados
            $updateStmt = $conn->prepare("UPDATE respostas SET keywords = ?, resposta = ? WHERE id = ?");
            $updateStmt->bind_param("ssi", $keywords, $resposta, $id);
            
            if ($updateStmt->execute()) {
                header('Location: admin.php');
                exit;
            }
        } else {
            $message = "Por favor, preencha todos os campos!";
        }
    }

    $stmt->close();
} else {
    header('Location: admin.php');
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Palavra-chave</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Editar Palavra-chave</h1>

    <!-- Exibir mensagens -->
    <?php if (isset($message)): ?>
        <p><strong><?php echo $message; ?></strong></p>
    <?php endif; ?>

    <!-- Formulário de edição -->
    <form action="edit.php?id=<?php echo $id; ?>" method="POST">
        <label for="keywords">Palavras-chave:</label>
        <input type="text" id="keywords" name="keywords" value="<?php echo htmlspecialchars($data['keywords']); ?>" required>

        <label for="resposta">Resposta:</label>
        <textarea id="resposta" name="resposta" required><?php echo htmlspecialchars($data['resposta']); ?></textarea>

        <button type="submit">Salvar</button>
    </form>

    <a href="admin.php">Voltar</a>
</body>
</html>
