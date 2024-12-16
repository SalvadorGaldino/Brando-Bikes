<?php
session_start();
include('db.php');

// Verificar se o usuário é admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit();
}

// Verificar se o ID do produto foi passado
if (isset($_GET['id'])) {
    $id_produto = $_GET['id'];

    // Buscar o produto pelo ID
    $sql = "SELECT * FROM estoque WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_produto);
    $stmt->execute();
    $produto = $stmt->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualizar as informações do estoque
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];

    $sql = "UPDATE estoque SET quantidade = ?, preco = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idi", $quantidade, $preco, $id_produto);
    $stmt->execute();

    echo "Estoque atualizado com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto no Estoque</title>
</head>
<body>
    <h1>Editar Produto</h1>
    <form action="editar_estoque.php?id=<?= $produto['id'] ?>" method="POST">
        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" value="<?= $produto['quantidade'] ?>" required>
        <br>
        <label for="preco">Preço:</label>
        <input type="text" name="preco" value="<?= $produto['preco'] ?>" required>
        <br>
        <input type="submit" value="Atualizar">
    </form>
</body>
</html>
