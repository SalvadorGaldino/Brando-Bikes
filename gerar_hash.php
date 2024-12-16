<?php
// Defina a senha que você quer gerar o hash
$senha = '1234';

// Crie o hash usando a função password_hash
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Exiba o hash gerado
echo "O hash da senha '$senha' é: " . $senha_hash;
?>
