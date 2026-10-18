<?php
require_once __DIR__ . '/../config/database.php';

class DashboardController {
    private $conn;

    public function __construct() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function index() {
        // 1. Total Products Count
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM products");
        $totalProducts = $stmt->fetch()['total'];

        // 2. Total Customers Count
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM customers");
        $totalCustomers = $stmt->fetch()['total'];

        // 3. Total Sales Amount Today
        $stmt = $this->conn->query("SELECT SUM(total_amount) as total FROM sales WHERE DATE(sale_date) = CURDATE()");
        $salesToday = $stmt->fetch()['total'] ?? 0;

        // 4. Low Stock Alerts (products where stock <= min_stock_level)
        $stmt = $this->conn->query("SELECT * FROM products WHERE stock_quantity <= min_stock_level ORDER BY stock_quantity ASC");
        $lowStockProducts = $stmt->fetchAll();

        $pageTitle = "Dashboard";
        $controller = 'dashboard';
        $action = 'index';

        require_once 'views/layouts/header.php';
        require_once 'views/dashboard/index.php';
        require_once 'views/layouts/footer.php';
    }
}
?>