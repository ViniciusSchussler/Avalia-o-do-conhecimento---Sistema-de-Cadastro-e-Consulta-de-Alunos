<?php
include 'db.php'; // Inclui o arquivo de conexão com o banco de dados

// Verifica se o ID do aluno foi passado na URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id) {
    // Busca os dados do aluno com base no ID
    $sql = "SELECT * FROM alunos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Liga o parâmetro da query ao ID (tipo inteiro)
    $stmt->execute();
    $result = $stmt->get_result(); // Obtém o resultado da consulta
    $aluno = $result->fetch_assoc(); // Obtém os dados do aluno
} else {
    // Redireciona para a lista de alunos se o ID não for válido
    header('Location: index.php');
    exit;
}

// Verifica se o formulário de atualização foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];

    // Atualiza os dados do aluno
    $sql = "UPDATE alunos SET nome = ?, idade = ?, email = ?, curso = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    // Liga os parâmetros da query aos valores do formulário
    $stmt->bind_param("sisii", $nome, $idade, $email, $curso, $id); // "s" para string, "i" para inteiro
    $stmt->execute(); // Executa a query

    if ($stmt->execute()) { // Executa a query e verifica se foi bem-sucedida
        // Redireciona de volta para a lista de alunos após a atualização
        header('Location: index.php?status=editar_sucesso');
    } else {
        // Redireciona de volta com um status de erro se a atualização falhar
        header('Location: index.php?status=editar_erro');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Editar Aluno</title>
</head>
<body>
    <h1>Editar Aluno</h1>
    <p>Preencha o formulário abaixo para atualizar os dados do aluno.</p> <!-- Mensagem informativa -->

    <form action="editar.php?id=<?= $id ?>" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($aluno['nome']) ?>" required pattern="[A-Za-z ]+"><br>

        <label for="idade">Idade:</label>
        <input type="number" name="idade" value="<?= htmlspecialchars($aluno['idade']) ?>" required min="1" max="120"><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($aluno['email']) ?>" required><br>

        <label for="curso">Curso:</label>
        <input type="text" name="curso" value="<?= htmlspecialchars($aluno['curso']) ?>" required><br>

        <button type="submit">Atualizar</button>
    </form>

    <a href="index.php">Voltar para a lista de alunos</a>
</body>
</html>
