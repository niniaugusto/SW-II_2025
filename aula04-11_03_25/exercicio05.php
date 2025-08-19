<?php 

$alunos = array(
    "Paulo" => 4,
    "Gabriel" => 5,
    "Bryan" => 7,
    "Kevyn" => 1
);


$totalNotas = 0;

foreach ($alunos as $nota) {
    $totalNotas += $nota;
}

$mediaNotas = $totalNotas / count($alunos);

echo "A média de notas é: ". $mediaNotas;
 
?>