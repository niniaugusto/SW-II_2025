<?php
header("Content-Type: application/json; charset=UTF-8");

$metodo = $_SERVER['REQUEST_METHOD'];

// Recupera o arquivo JSON
$arquivo = "autores.json";

// Verifica se o arquivo existe
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Variável que contém os dados do arquivo JSON
$autores = json_decode(file_get_contents($arquivo), true);

// Switch para cada método de requisição
switch ($metodo) {
    
    // MÉTODO GET -> Retorna todos os autores e retorna autor específico por ID
    case 'GET':
        // Verifica se há um parâmetro "id" na URL
        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);
            $autor_encontrado = null;

            // procura o autor pelo ID
            foreach ($autores as $autor) {
                if ($autor['id'] == $id) {
                    $autor_encontrado = $autor;
                    break;
                }
            }

            if ($autor_encontrado) {
                echo json_encode($autor_encontrado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(404);
                echo json_encode(["erro" => "Autor não encontrado"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                exit;
            }
        } else {
            // retorna todos os autores
            echo json_encode($autores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            exit;
        }
        break;


    // MÉTODO POST -> Adiciona autores
    case 'POST':
        $dados = json_decode(file_get_contents('php://input'), true);
        if (!$dados) {
            http_response_code(400);
            echo json_encode(["erro" => "JSON inválido"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            exit;
        }          

        // Verifica os campos obrigatorios (não precisa de ID)
        if (!isset($dados["nome"]) || !isset($dados["nacionalidade"]) || !isset($dados["nascimento"])) {
            http_response_code(400);
            echo json_encode(["erro" => "Nome, nacionalidade e nascimento são dados obrigatorios."], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit;
        }

        // Gera um novo ID para o autor baseado no anterior
        $novo_id = 1;
        if (!empty($autores)) {
            $ids = array_column($autores, "id");
            $novo_id = max($ids) + 1;
        }

        $novoAutor = [
            "id" => $novo_id,
            "nome" => $dados["nome"],
            "nacionalidade" => $dados["nacionalidade"],
            "nascimento" => $dados["nascimento"]
        ];

        // Adiciona o novo autor
        $autores[] = $novoAutor;

        // Salva o arquivo com o autor novo
        file_put_contents($arquivo, json_encode($autores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo json_encode(
            [
                "mensagem" => "Autor(a) adicionado(a) com sucesso.",
                "autores" => $autores
            ],
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
        exit;
        break;


        // MÉTODO PUT -> Atualiza os dados de um autor pelo seu ID
        case 'PUT':
        // Verifica se há o ID na URL
        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);
            $dados = json_decode(file_get_contents('php://input'), true);
            if (!$dados) {
                http_response_code(400);
                echo json_encode(["erro" => "JSON inválido"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                exit;
            }          

            // Verifica se o autor existe
            $autor_encontrado = null;
            foreach ($autores as &$autor) {
                if ($autor['id'] == $id) {
                    $autor_encontrado = &$autor;
                    break;
                }
            }

            // Atualiza os dados do autor
            if ($autor_encontrado) {
                if (isset($dados["nome"]))
                    $livro_encontrado["nome"] = $dados["nome"];
                if (isset($dados["nacionalidade"]))
                    $livro_encontrado["nacionalidade"] = $dados["nacionalidade"];
                if (isset($dados["nascimento"]))
                    $livro_encontrado["nascimento"] = $dados["nascimento"];

                // Salva o arquivo com a atualização feita
                file_put_contents($arquivo, json_encode($autores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                echo json_encode(
                    [
                        "mensagem" => "Os dados do(a) autor(a) foram atualizados com sucesso!",
                        "autor" => $autor_encontrado
                    ],
                    JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
                );
                exit;
            } else {
                http_response_code(404);
                echo json_encode(["erro" => "Autor(a) não encontrado(a) para atualização"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                exit;
            }
        } else {
            http_response_code(400);
            echo json_encode(["erro" => "ID não fornecido para atualização"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit;
        }
        break;


    // MÉTODO DELETE -> Deleta autor pelo seu ID
    case 'DELETE':
        // Verifica se há o ID na URL
        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);
            $autor_encontrado = null;
            $autores_novos = [];

            // Verifica se o autor existe e o remove
            foreach ($autores as $autor) {
                if ($autor['id'] != $id) {
                    $autores_novos[] = $autor;
                } else {
                    $autor_encontrado = $autor;
                }
            }

            // Salva o arquivo sem o autor que será deletado
            if ($autor_encontrado) {
                file_put_contents($arquivo, json_encode($autores_novos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                echo json_encode(
                    [
                        "mensagem" => "O(a) autor(a) com ID " . $autor['id'] . " foi excluído(a) com sucesso!",
                        "autor_removido" => $autor_encontrado
                    ],
                    JSON_UNESCAPED_UNICODE || JSON_PRETTY_PRINT
                );
                exit;
            } else {
                http_response_code(404);
                echo json_encode(["erro" => "Autor(a) não encontrado(a) para exclusão"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                exit;
            }
        } else {
            http_response_code(400);
            echo json_encode(["erro" => "ID não fornecido para exclusão"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit;
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["erro" => "Método não permitido."], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
        break;
}
?>