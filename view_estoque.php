<?php
include('db.php'); // Incluir a conexão com o banco de dados

// SQL para selecionar todos os produtos do estoque
$sql = "SELECT * FROM estoque";
$result = $conn->query($sql); // Executar a consulta

// Verificar se há produtos no estoque
if ($result->num_rows > 0) {
    // Exibir cada produto
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " - Produto: " . $row['produto'] . " - Quantidade: " . $row['quantidade'] . "<br>";
    }
} else {
    echo "Não há produtos no estoque.";
}

// Fechar a conexão
$conn->close();
?>
