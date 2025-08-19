<?php
header("Content-Type: application/json; charset=UTF-8");

$metodo = $_SERVER['REQUEST_METHOD'];

// Recupera o arquivo JSON
$arquivo = "livros.json";

// Verifica se o arquivo existe
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Variável que contém os dados do arquivo JSON
$livros = json_decode(file_get_contents($arquivo), true);

// Switch para cada método de requisição
switch ($metodo) {
    
    // MÉTODO GET -> Retorna todos os livros e retorna livro específico por ID
    case 'GET':
        // Verifica se há um parâmetro "id" na URL
        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);
            $livro_encontrado = null;

            // procura o livro pelo ID
            foreach ($livros as $livro) {
                if ($livro['id'] == $id) {
                    $livro_encontrado = $livro;
                    break;
                }
            }

            if ($livro_encontrado) {
                echo json_encode($livro_encontrado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(404);
                echo json_encode(["erro" => "Livro não encontrado"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        } else {
            // retorna todos os livros
            echo json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        break;


    // MÉTODO POST -> Adiciona livros
    case 'POST':
        $dados = json_decode(file_get_contents('php://input'), true);
        if (!$dados) {
            http_response_code(400);
            echo json_encode(["erro" => "JSON inválido"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            exit;
        }        

        // Verifica os campos obrigatorios para inserir o livro
        if (!isset($dados["isbn"]) || !isset($dados["titulo"]) || !isset($dados["autor_id"]) || !isset($dados["genero"]) || !isset($dados["editora"])) {
            http_response_code(400);
            echo json_encode(["erro" => "ID do autor, ISBN, título, ano de publicação, gênero e editora são obrigatorios. Veja se o autor já está adicionado em autores.json"], JSON_UNESCAPED_UNICODE || JSON_PRETTY_PRINT);
            exit;
        }

        // Gera um novo ID para o livro baseado no anterior
        $novo_id = 1;
        if (!empty($livros)) {
            $ids = array_column($livros, "id");
            $novo_id = max($ids) + 1;
        }

        $novoLivro = [
            "id" => $novo_id,
            "autor_id" => $dados["autor_id"],
            "isbn" => $dados["isbn"],
            "titulo" => $dados["titulo"],
            "ano_publicacao" => $dados["ano_publicacao"],
            "genero" => $dados["genero"],
            "editora" => $dados["editora"]
        ];

        // Adiciona o livro novo
        $livros[] = $novoLivro;

        // Salva o arquivo com o novo livro
        file_put_contents($arquivo, json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo json_encode(
            [
                "mensagem" => "Livro adicionado com sucesso!",
                "livros" => $livros
            ],
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
        exit;
        break;


        // MÉTODO PUT -> Atualiza os dados de um livro pelo seu ID
        case 'PUT':
        // Verifica se há o parâmetro ID na URL
        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);
            $dados = json_decode(file_get_contents('php://input'), true);
            if (!$dados) {
                http_response_code(400);
                echo json_encode(["erro" => "JSON inválido"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                exit;
            }            

            // Verifica se o livro existe
            $livro_encontrado = null;
            foreach ($livros as &$livro) {
                if ($livro['id'] == $id) {
                    $livro_encontrado = &$livro;
                    break;
                }
            }

            // Atualiza os dados do livro
            if ($livro_encontrado) {
                if (isset($dados["autor_id"]))
                    $livro_encontrado["autor_id"] = $dados["autor_id"];
                if (isset($dados["isbn"]))
                    $livro_encontrado["isbn"] = $dados["isbn"];
                if (isset($dados["titulo"]))
                    $livro_encontrado["titulo"] = $dados["titulo"];
                if (isset($dados["ano_publicacao"]))
                    $livro_encontrado["ano_publicacao"] = $dados["ano_publicacao"];
                if (isset($dados["genero"]))
                    $livro_encontrado["genero"] = $dados["genero"];
                if (isset($dados["editora"]))
                    $livro_encontrado["editora"] = $dados["editora"];

                // Salva o arquivo com a atualização feita
                file_put_contents($arquivo, json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                echo json_encode(
                    [
                        "mensagem" => "Os dados do livro foram atualizados com sucesso!",
                        "livro" => $livro_encontrado
                    ],
                    JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
                );
            } else {
                http_response_code(404);
                echo json_encode(["erro" => "Livro não encontrado para atualização"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                exit;
            }
        } else {
            http_response_code(400);
            echo json_encode(["erro" => "ID não fornecido para atualização"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit;
        }
        break;


    // MÉTODO DELETE -> Deleta livro pelo seu ID
    case 'DELETE':
        // Verifica se há o parâmetro ID na URL
        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);
            $livro_encontrado = null;
            $livros_novos = [];

            // Verifica se o livro existe e o remove
            foreach ($livros as $livro) {
                if ($livro['id'] != $id) {
                    $livros_novos[] = $livro;
                } else {
                    $livro_encontrado = $livro;
                }
            }

            // Salva o arquivo sem o livro que será deletado
            if ($livro_encontrado) {
                file_put_contents($arquivo, json_encode($livros_novos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                echo json_encode(
                    [
                        "mensagem" => "O livro com ID " . $livro['id'] . " foi excluído com sucesso!",
                        "livro_removido" => $livro_encontrado
                    ],
                    JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
                );
                exit;
            } else {
                http_response_code(404);
                echo json_encode(["erro" => "Livro não encontrado para exclusão"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
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