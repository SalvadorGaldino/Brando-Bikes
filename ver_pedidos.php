<?php
include 'db.php'; // Importando a conexão com o banco

// Validar se o usuário está autenticado
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Você precisa fazer login para acessar esta página.");
}

// Consultar pedidos seguros
$query = "SELECT * FROM pedidos WHERE user_id = '" . escape_input($conn, $_SESSION['user_id']) . "'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    echo "<h3>Seus Pedidos:</h3>";
    while ($row = $result->fetch_assoc()) {
        echo "<p>Pedido ID: " . htmlspecialchars($row['id']) . " | Data: " . htmlspecialchars($row['data']) . " | Total: R$ " . htmlspecialchars($row['total']) . "</p>";
    }
} else {
    echo "Nenhum pedido encontrado.";
}
?>
