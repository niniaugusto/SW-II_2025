<?php
$n1 = 8;
$n2 = 4;
$n3 = 10;

$m = ($n1+$n2+$n3)/3;

echo "Nota 1: $n1<br>";
echo "Nota 2: $n2<br>";
echo "Nota 3: $n3<br>";
echo "<br>";

echo "Média $m - ".($m > 5 ? "Aprovado" : "Reprovado");
?>