<?php

$host = "localhost";
$user = "root";
$password = "root";
$database = "Sistema_com_erros";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}


// CADASTRAR
if (isset($_POST['cadastrar'])) {

    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql = "INSERT INTO usuarios (nome, email) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $nome, $email);
        $stmt->execute();

    header("Location: index.php");
    exit;
}


// EXCLUIR
if (isset($_GET['excluir'])) {

    $id = $_GET['excluir'];

    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

// BUSCAR USUARIOS
$sql = "SELECT id, nome, email FROM usuarios ORDER BY id DESC";
$resultado = $conn->query($sql);

?>














<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>CRUD de Usuários</title>
</head>

<body>

    <h1>Cadastro de Usuários</h1>

    <form method="POST">

        <label>Nome:</label>
        <input type="text" name="nome" required>

        <br><br>

        <label>E-mail:</label>
        <input type="email" name="email" required>

        <br><br>

        <button type="submit" name="cadastrar">
            Cadastrar
        </button>


    </form>


    <h2>Usuários cadastrados</h2>

    <table border="1">

        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Ações</th>
            <th>Edição</th>
        </tr>












        <?php while ($usuario = $resultado->fetch_assoc()) { ?>

            <tr>

                <td>
                    <?= $usuario['id'] ?>
                </td>

                <td>
                    <?= $usuario['nome'] ?>
                </td>

                <td>
                    <?= $usuario['email'] ?>
                </td>

                <td>

                    <a href="index.php?excluir=<?= $usuario['id'] ?>">
                        Excluir
                    </a>

                </td>

                <td>

                <a href="editar.php?editar=<?= $usuario['id'] ?>">
                    Editar
                </a>

            </tr>

        <?php } ?>

    </table>

</body>

</html>
