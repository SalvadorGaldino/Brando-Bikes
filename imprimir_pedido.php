<?php
include('db.php'); // Inclua sua conexão com o banco de dados

// Verifica se o pedido existe
if (isset($_POST['pedido_id'])) {
    $pedido_id = $_POST['pedido_id'];
    $sql = "SELECT * FROM pedidos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pedido_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pedido = $result->fetch_assoc();
    $stmt->close();

    if ($pedido) {
        // Aqui você pode formatar a impressão ou gerar um PDF
        echo "<h1>Detalhes do Pedido</h1>";
        echo "<p>ID do Pedido: " . $pedido['id'] . "</p>";
        echo "<p>Nome do Cliente: " . $pedido['nome_cliente'] . "</p>";
        echo "<p>Produto: " . $pedido['produto'] . "</p>";
        echo "<p>Quantidade: " . $pedido['quantidade'] . "</p>";
        echo "<p>Status: " . $pedido['status'] . "</p>";
    } else {
        echo "Pedido não encontrado.";
    }
}
?>
