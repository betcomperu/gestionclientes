<?php
require_once __DIR__ . '/../config/database.php';

class ClienteModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Obtiene todos los clientes (sin información sensible)
     */
    public function obtenerTodos() {
        try {
            $sql = "SELECT id, nombre, apellido, correo, ciudad, fecha_nacimiento, usuario 
                    FROM clientes";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerTodos: " . $e->getMessage());
            throw new Exception("Error al obtener los clientes");
        }
    }

    /**
     * Obtiene un cliente por ID
     */
    public function obtenerPorId($id) {
        try {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException("ID debe ser numérico");
            }

            $query = "SELECT id, nombre, apellido, correo, ciudad, fecha_nacimiento, usuario 
                      FROM clientes WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$cliente) {
                throw new Exception("Cliente no encontrado", 404);
            }

            return $cliente;
        } catch (PDOException $e) {
            error_log("Error en obtenerPorId: " . $e->getMessage());
            throw new Exception("Error al obtener el cliente");
        }
    }

    /**
     * Autentica un cliente
     */
    public function autenticar($usuario, $clave) {
        try {
            $query = "SELECT * FROM clientes WHERE usuario = :usuario";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->execute();

            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cliente && password_verify($clave, $cliente['clave'])) {
                // No retornar la clave en ningún caso
                unset($cliente['clave']);
                return $cliente;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error en autenticar: " . $e->getMessage());
            throw new Exception("Error en el proceso de autenticación");
        }
    }

    /**
     * Crea un nuevo cliente
     */
    public function crear($datosCliente) {
        try {
            // Validación básica
            $this->validarDatosCliente($datosCliente);

            $claveEncriptada = password_hash($datosCliente['clave'], PASSWORD_BCRYPT);

            $sql = "INSERT INTO clientes 
                    (nombre, apellido, correo, ciudad, fecha_nacimiento, usuario, clave) 
                    VALUES (:nombre, :apellido, :correo, :ciudad, :fecha_nacimiento, :usuario, :clave)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':nombre', $datosCliente['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $datosCliente['apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':correo', $datosCliente['correo'], PDO::PARAM_STR);
            $stmt->bindParam(':ciudad', $datosCliente['ciudad'], PDO::PARAM_STR);
            $stmt->bindParam(':fecha_nacimiento', $datosCliente['fecha_nacimiento'], PDO::PARAM_STR);
            $stmt->bindParam(':usuario', $datosCliente['usuario'], PDO::PARAM_STR);
            $stmt->bindParam(':clave', $claveEncriptada, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }

            throw new Exception("Error al crear cliente");
        } catch (PDOException $e) {
            error_log("Error en crear: " . $e->getMessage());
            throw new Exception("Error al crear el cliente");
        }
    }

    /**
     * Actualiza un cliente existente
     */
    public function actualizar($id, $datosActualizados) {
        try {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException("ID debe ser numérico");
            }

            // No permitir actualización de clave directamente
            if (isset($datosActualizados['clave'])) {
                unset($datosActualizados['clave']);
            }

            $campos = [];
            foreach ($datosActualizados as $campo => $valor) {
                $campos[] = "$campo = :$campo";
            }

            $sql = "UPDATE clientes SET " . implode(', ', $campos) . " WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            foreach ($datosActualizados as $campo => $valor) {
                $stmt->bindValue(":$campo", $valor);
            }

            if (!$stmt->execute()) {
                throw new Exception("Error al actualizar cliente");
            }

            return true;
        } catch (PDOException $e) {
            error_log("Error en actualizar: " . $e->getMessage());
            throw new Exception("Error al actualizar el cliente");
        }
    }

    /**
     * Elimina un cliente
     */
    public function eliminar($id) {
        try {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException("ID debe ser numérico");
            }

            $this->conn->beginTransaction();

            // Eliminar pedidos relacionados primero
            $sqlPedidos = "DELETE FROM pedidos WHERE cliente_id = :id";
            $stmtPedidos = $this->conn->prepare($sqlPedidos);
            $stmtPedidos->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtPedidos->execute();

            // Luego eliminar el cliente
            $sqlCliente = "DELETE FROM clientes WHERE id = :id";
            $stmtCliente = $this->conn->prepare($sqlCliente);
            $stmtCliente->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtCliente->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error en eliminar: " . $e->getMessage());
            throw new Exception("Error al eliminar el cliente");
        }
    }

    /**
     * Valida los datos básicos del cliente
     */
    private function validarDatosCliente($datos) {
        $camposRequeridos = ['nombre', 'apellido', 'correo', 'usuario', 'clave'];
        
        foreach ($camposRequeridos as $campo) {
            if (empty($datos[$campo])) {
                throw new InvalidArgumentException("El campo $campo es requerido");
            }
        }

        if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Correo electrónico inválido");
        }
    }

      // Método alternativo (alias) para compatibilidad
      public function getAllClientes() {
        return $this->obtenerTodos();
    }


}