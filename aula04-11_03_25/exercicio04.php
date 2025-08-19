<?php 

$numeros = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15);

$qtde_par = 0;
$qtde_impar = 0;

foreach ($numeros as $num) {
    if ($num % 2 == 0) {
        $qtde_par++;
    } else {
        $qtde_impar++;
    }
}

echo "Quantidade de pares: " . $qtde_par;
echo "<br>";
echo "Quantidade de ímpares: " . $qtde_impar;

?>