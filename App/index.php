<?php
namespace App;
require "../vendor/autoload.php";

use App\Model\Cliente;
use App\Repository\ClienteRepository;
use App\Repository\MegaRepository;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

    $mega = new Cliente();
    $repository = new ClienteRepository();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        /*
        if (!isValid($data)) {
            http_response_code(400);
            echo json_encode(["error" => "Dados de entrada inválidos."]);
            break;
        }
        */
        
        $mega->setNome($data->nome)
        ->setEmail($data->email)
        ->setCidade($data->cidade)
        ->setEstado($data->estado);

        $success = $repository->insertCliente($mega);
        if ($success) {
            http_response_code(200);
            echo json_encode(["message" => "Dados inseridos com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Falha ao inserir dados."]);
        }
        break;
    case 'GET':
        if (isset($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                if ($id === false) {
                    http_response_code(400); 
                    echo json_encode(['error' => 'O valor do ID fornecido não é um inteiro válido.']);
                    exit;
                } else {
                    $mega->setId($id);
                    $result = $repository->getById($mega);
                }
            } else {
            $result = $repository->getAll();
        }

        if ($result) {
            http_response_code(200);
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Nenhum dado encontrado."]);
        }
        break;

    case "PUT":
        $data = json_decode(file_get_contents("php://input"));

        $mega->setNome($data->nome)
        ->setEmail($data->email)
        ->setCidade($data->cidade)
        ->setEstado($data->estado)
        ->setId($data->id);

        

        $success = $repository->updateCliente($mega);
        if ($success) {
            http_response_code(200);
            echo json_encode(["message" => "Dados atualizados com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Falha ao atualizar dados."]);
        }
    break;
    case "DELETE":
        $data = json_decode(file_get_contents("php://input"));
        $mega->setId($data->id);
        $success = $repository->deleteCliente($mega);
        if ($success) {
            http_response_code(200);
            echo json_encode(["message" => "Dados apagados com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Falha ao apagar dados."]);
        }
    break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Método não permitido."]);
        break;
}
