<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];

    $sql = "INSERT INTO alunos (nome, idade, email, curso) VALUES ('$nome', $idade, '$email', '$curso')";

    // Executa a query
    if ($conn->query($sql) === TRUE) {
        // Redireciona com mensagem de sucesso
        header("Location: index.php?status=sucesso");
        exit();
    } else {
        // Redireciona com mensagem de erro
        header("Location: index.php?status=erro");
        exit();
    }
}
$conn->close();

?>
