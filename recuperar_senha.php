<?php
include 'db.php'; // Importando a conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar e escapar entrada
    $username = escape_input($conn, $_POST['username']);

    // Verificar se o usuário existe no banco
    $query = "SELECT * FROM usuarios WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // Lógica para envio de e-mail de recuperação (simulada aqui)
        $user = $result->fetch_assoc();
        $email = $user['email']; // Certifique-se de que o campo 'email' existe no banco

        if ($email) {
            // Simular envio de email
            mail($email, "Recuperação de senha", "Solicitação de recuperação de senha para o seu usuário.");
            echo "E-mail de recuperação enviado com sucesso!";
        } else {
            echo "Este usuário não tem um e-mail associado.";
        }
    } else {
        echo "Usuário não encontrado.";
    }
}
?>

<form method="POST" action="recuperar_senha.php">
  <label>Nome de usuário:</label>
  <input type="text" name="username" required>
  <br>
  <button type="submit">Enviar recuperação</button>
</form>
