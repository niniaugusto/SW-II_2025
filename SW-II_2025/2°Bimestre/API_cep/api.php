<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>CEP - SW_II</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Consultar endereço por CEP</h2>

        <form method="GET" action="">
            <input type="text" name="cep" required placeholder="Ex: 01001000" minlength="8" maxlength="8">
            <button type="submit">Consultar</button>
        </form>

        <?php
        if (isset($_GET['cep'])) {

            $cep = $_GET['cep']; 

            if (strlen($cep) === 8) {
                $url = "https://viacep.com.br/ws/$cep/json/";

                $response = @file_get_contents($url);
                $data = json_decode($response, true);

                if (!$response || isset($data['erro'])) {
                    echo "<p class='erro'>CEP não encontrado.</p>";
                } else {
                    echo "<div class='resultado'>";
                    echo "<strong>CEP:</strong> " . $data['cep'] . "<br>";
                    echo "<strong>Logradouro:</strong> " . $data['logradouro'] . "<br>";
                    echo "<strong>Bairro:</strong> " . $data['bairro'] . "<br>";
                    echo "<strong>Cidade:</strong> " . $data['localidade'] . "<br>";
                    echo "<strong>UF:</strong> " . $data['uf'] . "<br>";
                    echo "<strong>Estado:</strong> " . $data['estado'] . "<br>";
                    echo "<strong>Região:</strong> " . $data['regiao'] . "<br>";
                    echo "</div>";
                }
            } else {
                echo "<p class='erro'>CEP inválido. Digite 8 números.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
