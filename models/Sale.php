<?php
require_once __DIR__ . '/../config/database.php';

class Sale {
    private $conn;
    private $table = 'sales';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createSale($customer_id, $user_id, $items) {
        try {
            // Start Transaction for ACID compliance and stock safety
            $this->conn->beginTransaction();

            $total_amount = 0;
            foreach ($items as $item) {
                // Check current stock and price
                $stmt = $this->conn->prepare("SELECT price, stock_quantity, name FROM products WHERE id = :id FOR UPDATE");
                $stmt->execute([':id' => $item['product_id']]);
                $product = $stmt->fetch();

                if (!$product) {
                    throw new Exception("Product not found.");
                }

                if ($product['stock_quantity'] < $item['quantity']) {
                    throw new Exception("Insufficient stock for product: " . $product['name'] . ". Available: " . $product['stock_quantity']);
                }

                $total_amount += $product['price'] * $item['quantity'];
            }

            // Insert into sales table
            $query = "INSERT INTO sales (customer_id, user_id, total_amount) VALUES (:customer_id, :user_id, :total_amount)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':customer_id' => $customer_id ?: null,
                ':user_id' => $user_id,
                ':total_amount' => $total_amount
            ]);
            $sale_id = $this->conn->lastInsertId();

            // Insert sale items and deduct stock
            foreach ($items as $item) {
                $stmt = $this->conn->prepare("SELECT price FROM products WHERE id = :id");
                $stmt->execute([':id' => $item['product_id']]);
                $prod = $stmt->fetch();
                $unit_price = $prod['price'];
                $subtotal = $unit_price * $item['quantity'];

                // Insert sale item
                $itemQuery = "INSERT INTO sale_items (sale_id, product_id, quantity, unit_price, subtotal) VALUES (:sale_id, :product_id, :quantity, :unit_price, :subtotal)";
                $itemStmt = $this->conn->prepare($itemQuery);
                $itemStmt->execute([
                    ':sale_id' => $sale_id,
                    ':product_id' => $item['product_id'],
                    ':quantity' => $item['quantity'],
                    ':unit_price' => $unit_price,
                    ':subtotal' => $subtotal
                ]);

                // Update stock quantity
                $stockQuery = "UPDATE products SET stock_quantity = stock_quantity - :quantity WHERE id = :product_id";
                $stockStmt = $this->conn->prepare($stockQuery);
                $stockStmt->execute([
                    ':quantity' => $item['quantity'],
                    ':product_id' => $item['product_id']
                ]);
            }

            // Commit Transaction
            $this->conn->commit();
            return $sale_id;

        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function getAllSales($start_date = '', $end_date = '') {
        $query = "SELECT s.*, c.name as customer_name, u.full_name as cashier_name 
                  FROM sales s 
                  LEFT JOIN customers c ON s.customer_id = c.id 
                  JOIN users u ON s.user_id = u.id WHERE 1=1";
        
        $params = [];
        if (!empty($start_date)) {
            $query .= " AND DATE(s.sale_date) >= :start_date";
            $params[':start_date'] = $start_date;
        }
        if (!empty($end_date)) {
            $query .= " AND DATE(s.sale_date) <= :end_date";
            $params[':end_date'] = $end_date;
        }

        $query .= " ORDER BY s.sale_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getSaleById($sale_id) {
        $query = "SELECT s.*, c.name as customer_name, c.phone as customer_phone, c.address as customer_address, u.full_name as cashier_name 
                  FROM sales s 
                  LEFT JOIN customers c ON s.customer_id = c.id 
                  JOIN users u ON s.user_id = u.id 
                  WHERE s.id = :sale_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':sale_id' => $sale_id]);
        return $stmt->fetch();
    }

    public function getSaleItems($sale_id) {
        $query = "SELECT si.*, p.name as product_name, p.sku 
                  FROM sale_items si 
                  JOIN products p ON si.product_id = p.id 
                  WHERE si.sale_id = :sale_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':sale_id' => $sale_id]);
        return $stmt->fetchAll();
    }
}
?>