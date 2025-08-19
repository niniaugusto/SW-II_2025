<?php 

$usuario_encontrado = null;

if (isset($_GET['email'])) {
    $email_procurado = $_GET['email'];

    $usuarios = json_decode(file_get_contents("usuarios.json"), true);

    foreach ($usuarios as $usuario) {
        if ($usuario['email'] === $email_procurado) {
            $usuario_encontrado = $usuario;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Exercício 4 - PHP</title>
</head>
<body>
    <h2>Buscar usuário</h2>
    <form method="GET">
        <input type="email" name="email" placeholder="Digite o email" required>
        <button type="submit">Buscar</button>
    </form>

    <?php if ($usuario_encontrado): ?>
        <p>Nome: <?= $usuario_encontrado['nome']; ?></p>
        <p>Email: <?= $usuario_encontrado['email']; ?></p>
    <?php elseif (isset($_GET['email'])): ?>
        <p style="color: red;">Usuário não encontrado</p>
    <?php endif; ?>
</body>
</html>
