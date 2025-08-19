<?php 

$pessoa = array(
    "nome" => "Paulo", 
    "idade" => 16, 
    "cidade" => "Ribeirão Pires"
);

$pessoa["profissao"] = "estudante";

$amigos = array("Gabriel", "Bryan", "Kevyn");

$dados = array_merge($pessoa, $amigos);

print_r($dados);

?>