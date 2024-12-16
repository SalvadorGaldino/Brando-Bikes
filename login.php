<?php
session_start();
include('db.php'); // Conexão com o banco de dados

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando os dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar se o usuário existe no banco de dados
    $sql = "SELECT * FROM usuarios WHERE nome_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // Usando bind_param para evitar SQL Injection
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuário encontrado
        $user = $result->fetch_assoc();

        // Verificar a senha usando password_verify
        if (password_verify($password, $user['senha'])) {
            // Se a senha for válida, o login é bem-sucedido
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['is_admin'] = $user['is_admin']; // Definindo o tipo de usuário (admin ou não)

            // Redirecionar para o painel (admin ou outro)
            header("Location: painel_admin.php"); 
            exit();  // Garante que o código após o header não seja executado
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Login</h1>

    <form action="login.php" method="POST">
        <label for="username">Nome de Usuário:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Senha:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Entrar</button>
    </form>

    <p><a href="criar_conta.php">Criar conta</a> | <a href="recuperar_senha.php">Esqueceu a senha?</a></p>

</body>
</html>
