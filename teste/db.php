<?php
// db.php
$host = 'localhost';
$db = 'escola';
$user = 'Vinicius';
$pass = '123456';
$port = 3307;

// Criar conexão
$conn = new mysqli($host, $user, $pass, $db, $port);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
