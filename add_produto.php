<?php
include('db.php'); // Incluir a conexão com o banco de dados

// Dados dos produtos a serem inseridos no estoque
$produtos = [
    ['produto' => 'Modelo Q3', 'quantidade' => 10], // Produto Q3 com 10 unidades
    ['produto' => 'Modelo A2', 'quantidade' => 5],  // Produto A2 com 5 unidades
];

// Inserir os produtos no banco de dados
foreach ($produtos as $produto) {
    $nome_produto = $produto['produto'];
    $quantidade = $produto['quantidade'];

    // SQL para inserir no banco
    $sql = "INSERT INTO estoque (produto, quantidade) VALUES ('$nome_produto', '$quantidade')";

    // Verificar se o produto foi inserido com sucesso
    if ($conn->query($sql) === TRUE) {
        echo "Produto '$nome_produto' adicionado com sucesso!<br>";
    } else {
        echo "Erro ao adicionar produto '$nome_produto': " . $conn->error . "<br>";
    }
}

// Fechar a conexão
$conn->close();
?>
