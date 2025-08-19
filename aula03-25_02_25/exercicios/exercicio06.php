<?php 

function numerosAleatorios() {
    $listaNumeros = array();
    
    for ($i = 1; $i <= 10; $i++) {
        array_push($listaNumeros, rand(1,100));
    }

    return $listaNumeros;
}

$listaAleatoria = numerosAleatorios();

foreach ($listaAleatoria as $num) {
    echo $num;
    echo "<br>";
} 

var_dump($listaAleatoria);

?>