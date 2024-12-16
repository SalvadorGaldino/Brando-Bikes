<?php
session_start(); // Iniciar a sessão para verificar se o vendedor está logado

// Verificar se o vendedor está logado
if (!isset($_SESSION['username'])) {
    header('Location: login.html'); // Redireciona para o login se não estiver logado
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Vendedor - Brando Bikes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Bem-vindo, <?php echo $_SESSION['username']; ?>!</h2>
        <p>Aqui você pode fazer pedidos para a fábrica.</p>

        <!-- Formulário de pedido -->
        <form action="fazer_pedido.php" method="POST">
            <label for="produto">Produto:</label>
            <select name="produto" id="produto" required>
                <option value="Modelo Q3">Modelo Q3</option>
                <option value="Modelo A2">Modelo A2</option>
            </select>

            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade" required>

            <button type="submit">Fazer Pedido</button>
        </form>

        <!-- Link para Logout -->
        <a href="logout.php">Sair</a>
    </div>
</body>
</html>
