<?php
session_start();
include('db.php'); // Inclua sua conexão com o banco de dados

// Verifica se o usuário é admin
if ($_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

// Função para visualizar os pedidos
function getPedidos() {
    global $conn;
    $sql = "SELECT * FROM pedidos";
    $result = $conn->query($sql);
    return $result;
}

// Função para visualizar o estoque
function getEstoque() {
    global $conn;
    $sql = "SELECT * FROM estoque";
    $result = $conn->query($sql);
    return $result;
}

// Função para atualizar o status do pedido
function atualizarStatusPedido($id, $status) {
    global $conn;
    $sql = "UPDATE pedidos SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();
}

// Ações para atualizar o status do pedido
if (isset($_POST['atualizar_status'])) {
    $pedido_id = $_POST['pedido_id'];
    $novo_status = $_POST['status'];

    // Atualiza o status
    atualizarStatusPedido($pedido_id, $novo_status);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Admin</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Adicionando estilo para as abas */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .navbar {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        /* Container principal */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        .tab-buttons {
            display: flex;
            justify-content: center;
            background-color: #333;
            width: 100%;
        }

        .tab-buttons button {
            background-color: #444;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            width: 50%;
        }

        .tab-buttons button:hover {
            background-color: #555;
        }

        .tab-buttons button.active {
            background-color: #007bff;
        }

        .tab-content {
            width: 90%;
            margin-top: 20px;
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        button {
            padding: 5px 10px;
            background-color: #007bff;
            border: none;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Painel de Admin</h2>
    </div>

    <div class="container">
        <!-- Abas -->
        <div class="tab-buttons">
            <button class="tab-button active" onclick="showTab('estoque')">Estoque</button>
            <button class="tab-button" onclick="showTab('pedidos')">Pedidos</button>
        </div>

        <!-- Conteúdo das Abas -->
        <div id="estoque" class="tab-content active">
            <h3>Gerenciar Estoque</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $estoque = getEstoque();
                        while ($item = $estoque->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo $item['produto']; ?></td>
                            <td><?php echo $item['quantidade']; ?></td>
                            <td class="action-buttons">
                                <button>Atualizar</button>
                                <button>Remover</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="pedidos" class="tab-content">
            <h3>Gerenciar Pedidos</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome Cliente</th>
                            <th>Produto</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pedidos = getPedidos();
                        while ($pedido = $pedidos->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $pedido['id']; ?></td>
                            <td><?php echo $pedido['nome_cliente']; ?></td>
                            <td><?php echo $pedido['produto']; ?></td>
                            <td><?php echo $pedido['status']; ?></td>
                            <td class="action-buttons">
                                <form method="POST" action="painel_admin.php">
                                    <input type="hidden" name="pedido_id" value="<?php echo $pedido['id']; ?>">
                                    <select name="status">
                                        <option value="Pendente" <?php echo $pedido['status'] == 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                                        <option value="Em Produção" <?php echo $pedido['status'] == 'Em Produção' ? 'selected' : ''; ?>>Em Produção</option>
                                        <option value="Finalizado" <?php echo $pedido['status'] == 'Finalizado' ? 'selected' : ''; ?>>Finalizado</option>
                                    </select>
                                    <button type="submit" name="atualizar_status">Atualizar Status</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            const tabs = document.querySelectorAll('.tab-content');
            const buttons = document.querySelectorAll('.tab-button');
            
            tabs.forEach(tab => tab.classList.remove('active'));
            buttons.forEach(button => button.classList.remove('active'));

            document.getElementById(tabName).classList.add('active');
            const activeButton = Array.from(buttons).find(button => button.textContent.toLowerCase() === tabName);
            activeButton.classList.add('active');
        }
    </script>
</body>
</html>
