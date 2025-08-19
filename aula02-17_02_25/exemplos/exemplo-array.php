<?php 

$nomes = ['ANA', 'BRUNO', 'JOAO', 'ROGERIO'];

$qtde = count($nomes);

echo "A quantidade de elementos na array é: " . $qtde . "<br>";

// for ($i = 0; $i < $qtde; $i++) {
//     echo $nomes[$i];
//     echo "<br>";
// }

foreach ($nomes as $nome) {
    echo "Nome: $nome <br>";
}

?>