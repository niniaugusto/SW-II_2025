<?php 

function tabuada($n) {
    for ($i = 1; $i <= 10; $i++) {
        echo " $n * $i = " . $n * $i;
        echo "<br>";
    }
}

$num = 7;
tabuada($num);

?>