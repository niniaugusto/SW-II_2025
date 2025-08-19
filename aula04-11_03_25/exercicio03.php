<?php

$numeros = array(22, 385, 7, 89, 23, 56, 3, 1);

$maior = $numeros[0];
$menor = $numeros[0];

foreach ($numeros as $num) {
    if ($num > $maior) {
        $maior = $num;
    }
    if ($num < $menor) {
        $menor = $num;
    }
}

echo "Maior número: " . $maior  . "<br>";
echo "Menor número: " . $menor;
?>
