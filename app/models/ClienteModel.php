<?php

require_once __DIR__ . '/../../config/database.php';

class ClienteModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function autenticar($usuario, $clave) {
        $query = "SELECT * FROM clientes WHERE usuario = :usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente && password_verify($clave, $cliente['clave'])) {
            unset($cliente['clave']); // No retornar la clave
            return $cliente;
        }
        return false;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM clientes";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM clientes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function insertar($cliente) {
        $sql = "INSERT INTO clientes (nombre, apellido, correo, ciudad, fecha_nacimiento, usuario, clave, foto) 
                VALUES (:nombre, :apellido, :correo, :ciudad, :fecha_nacimiento, :usuario, :clave, :foto)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre', $cliente['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $cliente['apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':correo', $cliente['correo'], PDO::PARAM_STR);
        $stmt->bindParam(':ciudad', $cliente['ciudad'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_nacimiento', $cliente['fecha_nacimiento'], PDO::PARAM_STR);
        $stmt->bindParam(':usuario', $cliente['usuario'], PDO::PARAM_STR);
        $stmt->bindParam(':clave', password_hash($cliente['clave'], PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->bindParam(':foto', $cliente['foto'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function actualizar($id, $data) {
        $sql = "UPDATE clientes SET 
                nombre = :nombre, 
                apellido = :apellido, 
                correo = :correo, 
                ciudad = :ciudad, 
                fecha_nacimiento = :fecha_nacimiento, 
                usuario = :usuario";

        if (!empty($data['clave'])) {
            $sql .= ", clave = :clave";
        }
        if (array_key_exists('foto', $data)) {
            if ($data['foto'] === null) {
                $sql .= ", foto = NULL";
            } else {
                $sql .= ", foto = :foto";
            }
        }

        $sql .= " WHERE id = :id";

        error_log("Datos enviados para actualizar: " . json_encode($data));
        error_log("Consulta SQL: " . $sql);

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $data['apellido'], PDO::PARAM_STR);
        $stmt->bindParam(':correo', $data['correo'], PDO::PARAM_STR);
        $stmt->bindParam(':ciudad', $data['ciudad'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_nacimiento', $data['fecha_nacimiento'], PDO::PARAM_STR);
        $stmt->bindParam(':usuario', $data['usuario'], PDO::PARAM_STR);

        if (!empty($data['clave'])) {
            $stmt->bindParam(':clave', password_hash($data['clave'], PASSWORD_DEFAULT), PDO::PARAM_STR);
        }
        if (!empty($data['foto'])) {
            $stmt->bindParam(':foto', $data['foto'], PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    public function eliminar($id) {
        $this->conn->beginTransaction();

        $sqlPedidos = "DELETE FROM pedidos WHERE cliente_id = :id";
        $stmtPedidos = $this->conn->prepare($sqlPedidos);
        $stmtPedidos->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtPedidos->execute();

        $sqlCliente = "DELETE FROM clientes WHERE id = :id";
        $stmtCliente = $this->conn->prepare($sqlCliente);
        $stmtCliente->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtCliente->execute();

        return $this->conn->commit();
    }
}