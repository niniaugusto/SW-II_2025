<?php 

function impar_ou_par($n) {
    if ($n % 2 == 0) {
        echo "O número $n é par";
    } else {
        echo "O número $n é ímpar";
    }
}

$num = 7;
impar_ou_par($num);

?>