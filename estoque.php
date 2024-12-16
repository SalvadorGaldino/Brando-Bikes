<?php
include 'db.php';

// Consulta o estoque
$sql = "SELECT * FROM estoque";
$stmt = $pdo->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque - Brando Bikes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Estoque - Brando Bikes</h1>
    </header>
    <div class="container">
        <h2>Produtos Disponíveis</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['produto']; ?></td>
                        <td><?php echo $row['quantidade']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
