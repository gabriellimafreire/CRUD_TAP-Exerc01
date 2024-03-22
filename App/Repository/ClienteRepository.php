<?php
namespace App\Repository;

use App\Database\Database;
use App\Model\Cliente;
use PDO;
class ClienteRepository {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function insertCliente(Cliente $cliente) {
        $query = "INSERT INTO Cliente (nome, email, cidade, estado) VALUES (:nome, :email, :cidade, :estado)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $cliente->getNome());
        $stmt->bindParam(":email", $cliente->getEmail());
        $stmt->bindParam(":cidade", $cliente->getCidade());
        $stmt->bindParam(":estado", $cliente->getEstado());

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function updateCliente(Cliente $cliente) {
        $query = "UPDATE Cliente SET nome=:nome, email=:email, cidade=:cidade, estado=:estado WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $cliente->getNome());
        $stmt->bindParam(":email", $cliente->getEmail());
        $stmt->bindParam(":cidade", $cliente->getCidade());
        $stmt->bindParam(":estado", $cliente->getEstado());
        $stmt->bindParam(":id", $cliente->getId());

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function deleteCliente(Cliente $cliente){
        $query = "DELETE FROM Cliente WHERE id = :id ";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $cliente->getId());

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getAll() {
        $query = "SELECT * FROM Cliente";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(Cliente $cliente) {
        $id = $cliente->getId();
        $query = "SELECT * FROM Cliente WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id , PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
