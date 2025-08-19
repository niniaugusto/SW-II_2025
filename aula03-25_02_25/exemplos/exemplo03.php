<?php 

// FUNÇÃO SEM PARÂMETROS E COM RETORNO
function msg() {
    $a = "Paulo";
    return $a;
}

$frase = "Olá ";
$frase .= msg();

echo $frase;

?>