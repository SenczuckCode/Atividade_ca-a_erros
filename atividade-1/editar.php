<?php

include 'conexao.php';
$id = $_GET['editar'];

if (isset($_GET['editar'])) {
    $id = $_GET['editar'];


$sql = "SELECT id, nome, email FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();
}

if (isset($_POST['Editar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nome, $email, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<form action="editar.php" method="POST">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" value="<?= $usuario['nome'] ?>" required>
    <br>
    <label for="email">E-mail:</label>
    <input type="email" name="email" value="<?= $usuario['email'] ?>" required>
    <br>
    <button type="submit" name="Editar">Editar</button>
</form>
