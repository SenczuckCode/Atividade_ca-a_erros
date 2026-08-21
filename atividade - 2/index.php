<?php

$host = "localhost";
$user = "root";
$password = "root";
$database = "Sistema_loja_erros_2";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Erro na conexao: " . $conn->connect_error);
}


// ============================================================
// CADASTRAR PRODUTO
// ============================================================

if (isset($_POST['cadastrar'])) {

    $nome = $_POST['nome'];
    $categoria = $_POST['categoria'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];

    $sql = "INSERT INTO produtos
            (nome, categoria, preco, estoque)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssdi",
        $nome,
        $categoria,
        $preco,
        $estoque
    );

    $stmt->execute();

    header("Location: index.php");
    exit;
}


// ============================================================
// EXCLUIR PRODUTO
// ============================================================

if (isset($_GET['excluir'])) {

    $id = $_GET['excluir'];

    $sql = "DELETE FROM produtos WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id);

    $stmt->execute();

    header("Location: index.php");
    exit;
}


// ============================================================
// BUSCAR PRODUTO PARA EDITAR
// ============================================================

$produtoEditar = null;

if (isset($_GET['editar'])) {

    $id = $_GET['editar'];

    $sql = "SELECT id, nome, categoria, preco, estoque
            FROM produtos
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $resultadoEditar = $stmt->get_result();

    $produtoEditar = $resultadoEditar->fetch_assoc();
}


// ============================================================
// ATUALIZAR PRODUTO
// ============================================================

if (isset($_POST['atualizar'])) {

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $categoria = $_POST['categoria'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];

    $sql = "UPDATE produtos
            SET nome = ?,
                categoria = ?,
                preco = ?,
                estoque = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssdii",
        $nome,
        $categoria,
        $preco,
        $estoque,
        $id
    );

    $stmt->execute();

    header("Location: index.php");
    exit;
}


// ============================================================
// BUSCAR PRODUTOS
// ============================================================

$sql = "SELECT id, nome, categoria, preco, estoque
        FROM produtos
        ORDER BY id DESC";

$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>CRUD de Produtos</title>

</head>

<body>

    <h1>Cadastro de Produtos</h1>


    <!-- ============================================================ -->
    <!-- FORMULARIO -->
    <!-- ============================================================ -->

    <?php if ($produtoEditar) { ?>

        <h2>Editar Produto</h2>

        <form method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= $produtoEditar['id'] ?>"
            >

            <label>Nome:</label>

            <input
                type="text"
                name="nome"
                value="<?= $produtoEditar['nome'] ?>"
                required
            >

            <br><br>


            <label>Categoria:</label>

            <input
                type="text"
                name="categoria"
                value="<?= $produtoEditar['categoria'] ?>"
                required
            >

            <br><br>


            <label>Preço:</label>

            <input
                type="number"
                step="0.01"
                name="preco"
                value="<?= $produtoEditar['preco'] ?>"
                required
            >

            <br><br>


            <label>Estoque:</label>

            <input
                type="number"
                name="estoque"
                value="<?= $produtoEditar['estoque'] ?>"
                required
            >

            <br><br>


            <button type="submit" name="atualizar">
                Atualizar Produto
            </button>

            <a href="index.php">
                Cancelar
            </a>

        </form>


    <?php } else { ?>


        <form method="POST">

            <label>Nome:</label>

            <input
                type="text"
                name="nome"
                required
            >

            <br><br>


            <label>Categoria:</label>

            <input
                type="text"
                name="categoria"
                required
            >

            <br><br>


            <label>Preço:</label>

            <input
                type="number"
                step="0.01"
                name="preco"
                required
            >

            <br><br>


            <label>Estoque:</label>

            <input
                type="number"
                name="estoque"
                required
            >

            <br><br>


            <button type="submit" name="cadastrar">
                Cadastrar Produto
            </button>

        </form>

    <?php } ?>


    <br>


    <!-- ============================================================ -->
    <!-- LISTAGEM -->
    <!-- ============================================================ -->

    <h2>Produtos cadastrados</h2>

    <table border="1" cellpadding="6">

        <tr>

            <th>ID</th>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th>Ações</th>

        </tr>


        <?php while ($produto = $resultado->fetch_assoc()) { ?>

            <tr>

                <td>
                    <?= $produto['id'] ?>
                </td>

                <td>
                    <?= $produto['nome'] ?>
                </td>

                <td>
                    <?= $produto['categoria'] ?>
                </td>

                <td>
                    R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                </td>

                <td>
                    <?= $produto['estoque'] ?>
                </td>

                <td>

                    <a href="index.php?editar=<?= $produto['id'] ?>">
                        Editar
                    </a>

                    |

                    <a href="index.php?excluir=<?= $produto['id'] ?>">
                        Excluir
                    </a>

                </td>

            </tr>

        <?php } ?>

    </table>

</body>

</html>