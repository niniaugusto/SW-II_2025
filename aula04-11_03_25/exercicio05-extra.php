<?php 

$alunos = array(
    "Paulo" => 10,
    "Gabriel" => 9,
    "Bryan" => 7,
    "Kevyn" => 8
);

$maiorNota = 0; 
$alunoMaiorNota = "";

foreach ($alunos as $nome => $nota) {
    if ($nota > $maiorNota) {
        $maiorNota = $nota;
        $alunoMaiorNota = $nome;
    }
}

echo "O aluno com a maior nota é " . $alunoMaiorNota . ", com nota " . $maiorNota;

?>
