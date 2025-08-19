<?php

$dados = file_get_contents("produtos.json");
$dados_produtos = json_decode($dados, true);

array_push($dados_produtos, [
    "nome" => "Televisao",
    "preco" => 5000.00,
    "quantidade" => 10
]);

echo "Novo produto adicionado com sucesso!";

$json = json_encode($dados_produtos, JSON_PRETTY_PRINT);
file_put_contents("produtos.json", $json);

?>