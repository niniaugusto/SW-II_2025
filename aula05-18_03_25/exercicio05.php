<?php

$produto_removido = "Televisao"; 

$dados = file_get_contents("produtos.json");
$produtos = json_decode($dados, true);

foreach ($produtos as $index => $produto) {
    if ($produto['nome'] === $produto_removido) {
        unset($produtos[$index]);
        break;  
    }
}

# Usando array_values pq depois do unset ele n reindexa automaticamente os indices
$json_produtos = json_encode(array_values($produtos), JSON_PRETTY_PRINT);

file_put_contents("produtos.json", $json_produtos);

echo "Produto removido";

?>
