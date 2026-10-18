<?php
require_once __DIR__ . '/../config/database.php';

class Product {
    private $conn;
    private $table = 'products';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll($search = '', $category_id = '') {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  JOIN categories c ON p.category_id = c.id WHERE 1=1";
        
        $params = [];

        if (!empty($search)) {
            $query .= " AND (p.name LIKE :search OR p.sku LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        if (!empty($category_id)) {
            $query .= " AND p.category_id = :category_id";
            $params[':category_id'] = $category_id;
        }

        $query .= " ORDER BY p.name ASC";
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

    public function create($category_id, $name, $sku, $price, $stock_quantity, $min_stock_level) {
        $query = "INSERT INTO " . $this->table . " (category_id, name, sku, price, stock_quantity, min_stock_level) 
                  VALUES (:category_id, :name, :sku, :price, :stock_quantity, :min_stock_level)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock_quantity', $stock_quantity);
        $stmt->bindParam(':min_stock_level', $min_stock_level);
        return $stmt->execute();
    }

    public function update($id, $category_id, $name, $sku, $price, $stock_quantity, $min_stock_level) {
        $query = "UPDATE " . $this->table . " 
                  SET category_id = :category_id, name = :name, sku = :sku, price = :price, 
                      stock_quantity = :stock_quantity, min_stock_level = :min_stock_level 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock_quantity', $stock_quantity);
        $stmt->bindParam(':min_stock_level', $min_stock_level);
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