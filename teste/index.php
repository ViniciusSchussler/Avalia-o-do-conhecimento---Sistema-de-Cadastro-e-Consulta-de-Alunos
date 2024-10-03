<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cadastro de Alunos</title>
</head>
<body>
    <h1>Cadastro de Alunos</h1>
    <form action="cadastro.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required pattern="[A-Za-z ]+">
        
        <label for="idade">Idade:</label>
        <input type="number" name="idade" id="idade" required min="1" max="120">
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        
        <label for="curso">Curso:</label>
        <input type="text" name="curso" id="curso" required>

        <button type="submit">Cadastrar</button>
    </form>
    
    <div class="mensagem">
        <?php
        // Verifica se há algum status passado pela URL
        $status = isset($_GET['status']) ? $_GET['status'] : '';

        if ($status == 'cadastrar_sucesso') {
            echo "<p style='color: green;'>Aluno cadastrado com sucesso!</p>";
        } elseif ($status == 'cadastrar_erro') {
            echo "<p style='color: red;'>Erro ao cadastrar o aluno. Tente novamente.</p>";
        } elseif ($status == 'editar_sucesso') {
            echo "<p style='color: green;'>Dados do aluno atualizados com sucesso!</p>";
        } elseif ($status == 'editar_erro') {
            echo "<p style='color: red;'>Erro ao atualizar o aluno. Tente novamente.</p>";
        } elseif ($status == 'excluir_sucesso') {
            echo "<p style='color: green;'>Aluno excluído com sucesso!</p>";
        } elseif ($status == 'excluir_erro') {
            echo "<p style='color: red;'>Erro ao excluir o aluno. Tente novamente.</p>";
        }
        ?>
    </div>

    <form method="GET" action="">
        <?php 
        // Inicializa a variável $pesquisa
        $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : ''; 
        ?>
        <input type="text" name="pesquisa" placeholder="Pesquisar por nome ou curso" value="<?php echo htmlspecialchars($pesquisa); ?>">
        <button type="submit">Pesquisar</button>
    </form>

    <h2>Alunos Cadastrados</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Idade</th>
            <th>Email</th>
            <th>Curso</th>
            <th>Ações</th>
        </tr>
        
        <?php
        include 'db.php';

        // Cria a consulta com base na pesquisa
        $sql = "SELECT * FROM alunos WHERE nome LIKE '%$pesquisa%' OR curso LIKE '%$pesquisa%'";
        $result = $conn->query($sql);

        // Verifica se há alunos cadastrados
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nome']}</td>
                        <td>{$row['idade']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['curso']}</td>
                        <td>
                            <a href='editar.php?id={$row['id']}'>Editar</a> | 
                            <a href='deletar.php?id={$row['id']}'>Excluir</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nenhum aluno encontrado.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
