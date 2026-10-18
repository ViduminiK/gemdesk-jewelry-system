<?php
require_once __DIR__ . '/../models/Sale.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Customer.php';

class SalesController {
    private $saleModel;
    private $productModel;
    private $customerModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        $this->saleModel = new Sale();
        $this->productModel = new Product();
        $this->customerModel = new Customer();
    }

    public function create() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $customer_id = $_POST['customer_id'] ?? null;
            $product_ids = $_POST['product_ids'] ?? [];
            $quantities = $_POST['quantities'] ?? [];

            $items = [];
            for ($i = 0; $i < count($product_ids); $i++) {
                if (!empty($product_ids[$i]) && !empty($quantities[$i]) && $quantities[$i] > 0) {
                    $items[] = [
                        'product_id' => $product_ids[$i],
                        'quantity' => intval($quantities[$i])
                    ];
                }
            }

            if (empty($items)) {
                $error = "Please add at least one product to the sale.";
            } else {
                try {
                    $sale_id = $this->saleModel->createSale($customer_id, $_SESSION['user_id'], $items);
                    header("Location: index.php?controller=sales&action=view&id=" . $sale_id);
                    exit();
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $products = $this->productModel->getAll();
        $customers = $this->customerModel->getAll();

        $pageTitle = "New Sale (POS)";
        $controller = 'sales';
        $action = 'create';

        require_once 'views/layouts/header.php';
        require_once 'views/sales/create.php';
        require_once 'views/layouts/footer.php';
    }

    public function history() {
        $sales = $this->saleModel->getAllSales();

        $pageTitle = "Sales History";
        $controller = 'sales';
        $action = 'history';

        require_once 'views/layouts/header.php';
        require_once 'views/sales/history.php';
        require_once 'views/layouts/footer.php';
    }

    public function view() {
        $id = $_GET['id'] ?? '';
        $sale = $this->saleModel->getSaleById($id);
        $items = $this->saleModel->getSaleItems($id);

        if (!$sale) {
            header("Location: index.php?controller=sales&action=history");
            exit();
        }

        $pageTitle = "Sale Invoice #" . $sale['id'];
        $controller = 'sales';
        $action = 'history';

        require_once 'views/layouts/header.php';
        require_once 'views/sales/view.php';
        require_once 'views/layouts/footer.php';
    }

    public function report() {
        $start_date = $_GET['start_date'] ?? '';
        $end_date = $_GET['end_date'] ?? '';

        $sales = $this->saleModel->getAllSales($start_date, $end_date);
        
        $totalRevenue = 0;
        foreach ($sales as $s) {
            $totalRevenue += $s['total_amount'];
        }

        $pageTitle = "Sales Reports";
        $controller = 'sales';
        $action = 'report';

        require_once 'views/layouts/header.php';
        require_once 'views/sales/report.php';
        require_once 'views/layouts/footer.php';
    }
}
?>