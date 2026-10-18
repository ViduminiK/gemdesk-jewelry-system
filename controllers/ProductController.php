<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';

class ProductController {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function index() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $category_id = isset($_GET['category_id']) ? trim($_GET['category_id']) : '';

        $products = $this->productModel->getAll($search, $category_id);
        $categories = $this->categoryModel->getAll();

        $pageTitle = "Products & Inventory";
        $controller = 'product';
        $action = 'index';

        require_once 'views/layouts/header.php';
        require_once 'views/products/index.php';
        require_once 'views/layouts/footer.php';
    }

    public function create() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $category_id = trim($_POST['category_id']);
            $name = trim($_POST['name']);
            $sku = trim($_POST['sku']);
            $price = trim($_POST['price']);
            $stock_quantity = trim($_POST['stock_quantity']);
            $min_stock_level = trim($_POST['min_stock_level']);

            if (!empty($name) && !empty($sku) && !empty($price)) {
                if ($this->productModel->create($category_id, $name, $sku, $price, $stock_quantity, $min_stock_level)) {
                    header("Location: index.php?controller=product&action=index");
                    exit();
                } else {
                    $error = "Failed to add product. SKU might already exist.";
                }
            } else {
                $error = "Please fill in all required fields.";
            }
        }

        $categories = $this->categoryModel->getAll();
        $pageTitle = "Add New Product";
        $controller = 'product';
        $action = 'create';

        require_once 'views/layouts/header.php';
        require_once 'views/products/create.php';
        require_once 'views/layouts/footer.php';
    }

    public function edit() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $product = $this->productModel->getById($id);

        if (!$product) {
            header("Location: index.php?controller=product&action=index");
            exit();
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $category_id = trim($_POST['category_id']);
            $name = trim($_POST['name']);
            $sku = trim($_POST['sku']);
            $price = trim($_POST['price']);
            $stock_quantity = trim($_POST['stock_quantity']);
            $min_stock_level = trim($_POST['min_stock_level']);

            if (!empty($name) && !empty($sku) && !empty($price)) {
                if ($this->productModel->update($id, $category_id, $name, $sku, $price, $stock_quantity, $min_stock_level)) {
                    header("Location: index.php?controller=product&action=index");
                    exit();
                } else {
                    $error = "Failed to update product. SKU might already exist.";
                }
            } else {
                $error = "Please fill in all required fields.";
            }
        }

        $categories = $this->categoryModel->getAll();
        $pageTitle = "Edit Product";
        $controller = 'product';
        $action = 'edit';

        require_once 'views/layouts/header.php';
        require_once 'views/products/edit.php';
        require_once 'views/layouts/footer.php';
    }

    public function delete() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if (!empty($id)) {
            try {
                $this->productModel->delete($id);
                header("Location: index.php?controller=product&action=index");
                exit();
            } catch (PDOException $e) {
                // Redirect back with an error message or handle gracefully
                $error = "Cannot delete this product because it has existing sales records.";
                // Let's pass the error via a session flash message or re-display index with error
                $_SESSION['flash_error'] = "Cannot delete this product because it has associated sales history.";
            }
        }
        header("Location: index.php?controller=product&action=index");
        exit();
    }
}
?>