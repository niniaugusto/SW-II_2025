<?php 

function somaTotal($v) {
    $soma = 0;
    foreach ($v as $elemento) {
        $soma += $elemento;
    }
    return $soma;
}

$vetor = [1, 3, 5, 7, 9, 11];
$soma = somaTotal($vetor);
echo $soma;

?>