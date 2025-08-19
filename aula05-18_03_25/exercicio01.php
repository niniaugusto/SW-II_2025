<?php

$produtos = [
    [
        "nome" => "Notebook",
        "preco" => 4500.00,
        "quantidade" => 10
    ],
    [
        "nome" => "Smartphone",
        "preco" => 1500.00,
        "quantidade" => 20
    ],
    [
        "nome" => "Fone de ouvido",
        "preco" => 150.00,
        "quantidade" => 50
    ]
];

$json = json_encode($produtos, JSON_PRETTY_PRINT);

file_put_contents("produtos.json", $json);

?>
