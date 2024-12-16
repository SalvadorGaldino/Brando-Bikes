<?php
include 'db.php'; // Importando a conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar e escapar entradas
    $nome_usuario = trim($_POST['nome_usuario']); // Remover espaços e limpar entrada
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validar se as senhas coincidem
    if ($password !== $confirm_password) {
        echo "As senhas não coincidem.";
        exit();
    }

    // Hash da senha com segurança
    $senha_hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Verificar se o usuário já existe
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nome_usuario = ?");
        $stmt->bind_param("s", $nome_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Usuário já existe.";
        } else {
            // Inserir novo usuário no banco de dados
            $insert_stmt = $conn->prepare("INSERT INTO usuarios (nome_usuario, senha) VALUES (?, ?)");
            $insert_stmt->bind_param("ss", $nome_usuario, $senha_hash);

            if ($insert_stmt->execute()) {
                echo "Conta criada com sucesso! Faça login agora.";
            } else {
                echo "Erro ao criar conta. Tente novamente.";
            }
        }
    } catch (Exception $e) {
        echo "Erro no banco de dados: " . $e->getMessage();
    }
}
?>

<form method="POST" action="criar_conta.php">
  <label>Nome de usuário:</label>
  <input type="text" name="nome_usuario" required>
  <br>
  <label>Senha:</label>
  <input type="password" name="password" required>
  <br>
  <label>Confirme a senha:</label>
  <input type="password" name="confirm_password" required>
  <br>
  <button type="submit">Criar Conta</button>
</form>
