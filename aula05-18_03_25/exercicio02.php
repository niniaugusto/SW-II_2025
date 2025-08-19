<?php 

$dados = file_get_contents("usuarios.json");
$dados_usuarios = json_decode($dados, true);

foreach ($dados_usuarios as $usuario) {
    echo "Nome: " . $usuario['nome'] . " - Email: " . $usuario['email'] . "<br>";
}

?>