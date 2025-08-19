<?php

$nota1 = 8;
$nota2 = 7;
$nota3 = 9;

$media = ($nota1 + $nota2 + $nota3) / 3;

if ($media >= 6) {
    $status = "Aprovado";
} else {
    $status = "Recusado";
}

echo "Nota 1: ". $nota1 . "<br>";
echo "Nota 2: ". $nota2 . "<br>";
echo "Nota 3: ". $nota3 . "<br>";

echo "<br>";

echo "Média: ".$media." - ". $status;

?>