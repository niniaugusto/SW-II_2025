<?php 

function fatorial($n) {
    if ($n == 0) {
        return 1;
    } else {
        $total = 1;
        for ($n; $n > 0; $n--) {
            $total *= $n;
        }
        return $total;
    }
}

$num = 6;
$fatorial = fatorial($num);
echo $fatorial;

?>