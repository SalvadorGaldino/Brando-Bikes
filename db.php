<?php
ini_set('memory_limit', '256M'); // Aumentando o limite de memória para evitar o erro

$host = 'localhost'; // servidor
$user = 'root'; // usuário padrão do XAMPP
$password = ''; // senha padrão do XAMPP
$dbname = 'brando_bikes'; // nome do banco de dados

// Criar a conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar se houve erro na conexão
if ($conn->connect_error) {
    error_log("Erro de conexão: " . $conn->connect_error); // Log de erro
    die("Erro ao conectar ao banco de dados. Tente novamente mais tarde.");
}

// Função para escapar entradas seguras
function escape_input($conn, $input) {
    return $conn->real_escape_string($input);
}
?>
