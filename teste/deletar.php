<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM alunos WHERE id=?";
    
    // Prepara a consulta para evitar SQL Injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Liga o parâmetro da query ao ID (tipo inteiro)

    if ($stmt->execute() === TRUE) {
        // Redireciona com status de sucesso
        header("Location: index.php?status=excluir_sucesso");
        exit();
    } else {
        // Redireciona com status de erro
        header("Location: index.php?status=excluir_erro");
        exit();
    }
}

$conn->close();
?>
