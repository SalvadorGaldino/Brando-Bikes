<?php
session_start();

// Verificar se o vendedor está logado
if (!isset($_SESSION['username'])) {
    header('Location: login.html'); // Redireciona para a tela de login caso não esteja logado
    exit;
}

// Incluir a conexão com o banco de dados
include('db.php');

// Receber os dados do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto = $_POST['produto'];
    $quantidade = $_POST['quantidade'];

    // Verificar se a quantidade solicitada está disponível no estoque
    $sql_estoque = "SELECT quantidade FROM estoque WHERE produto = '$produto'";
    $result = $conn->query($sql_estoque);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $estoque_disponivel = $row['quantidade'];

        // Verificar se a quantidade solicitada é menor ou igual ao estoque disponível
        if ($quantidade <= $estoque_disponivel) {
            // Inserir o pedido no banco de dados
            $sql_pedido = "INSERT INTO pedidos (vendedor, produto, quantidade) 
                           VALUES ('" . $_SESSION['username'] . "', '$produto', $quantidade)";

            if ($conn->query($sql_pedido) === TRUE) {
                // Atualizar o estoque, diminuindo a quantidade solicitada
                $nova_quantidade = $estoque_disponivel - $quantidade;
                $sql_atualizar_estoque = "UPDATE estoque SET quantidade = $nova_quantidade WHERE produto = '$produto'";

                if ($conn->query($sql_atualizar_estoque) === TRUE) {
                    echo "<p>Pedido de $quantidade unidades do produto '$produto' realizado com sucesso!</p>";
                } else {
                    echo "<p>Erro ao atualizar o estoque: " . $conn->error . "</p>";
                }
            } else {
                echo "<p>Erro ao realizar o pedido: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Quantidade solicitada excede o estoque disponível. Estoque disponível: $estoque_disponivel unidades.</p>";
        }
    } else {
        echo "<p>Produto não encontrado no estoque.</p>";
    }
}

$conn->close();
?>
