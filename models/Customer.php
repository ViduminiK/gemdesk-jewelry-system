<?php
require_once __DIR__ . '/../config/database.php';

class Customer {
    private $conn;
    private $table = 'customers';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll($search = '') {
        $query = "SELECT * FROM " . $this->table;
        $params = [];

        if (!empty($search)) {
            $query .= " WHERE name LIKE :search OR phone LIKE :search OR email LIKE :search";
            $params[':search'] = '%' . $search . '%';
        }

        $query .= " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($name, $phone, $email, $address) {
        $query = "INSERT INTO " . $this->table . " (name, phone, email, address) VALUES (:name, :phone, :email, :address)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        return $stmt->execute();
    }

    public function update($id, $name, $phone, $email, $address) {
        $query = "UPDATE " . $this->table . " SET name = :name, phone = :phone, email = :email, address = :address WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>