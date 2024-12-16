<?php
include('db.php'); // Inclua sua conexão com o banco de dados

// Dados do usuário
$nome_usuario = 'netoo';
$email = 'netoo@example.com';
$senha = '1234'; // Senha em texto simples (a senha será hashada)
$is_admin = 1; // Definindo como admin

// Criptografando a senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// SQL para inserir o novo usuário
$sql = "INSERT INTO usuarios (nome_usuario, email, senha, is_admin) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $nome_usuario, $email, $senha_hash, $is_admin);

// Executando a consulta
if ($stmt->execute()) {
    echo "Usuário admin 'netoo' criado com sucesso!";
} else {
    echo "Erro ao criar o usuário: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
