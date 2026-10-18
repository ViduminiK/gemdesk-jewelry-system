<?php
require_once __DIR__ . '/../models/Category.php';

class CategoryController {
    private $categoryModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        $this->categoryModel = new Category();
    }

    public function index() {
        $error = $_SESSION['flash_error'] ?? '';
        $success = $_SESSION['flash_success'] ?? '';
        unset($_SESSION['flash_error'], $_SESSION['flash_success']);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);

            if (!empty($name)) {
                if ($this->categoryModel->create($name, $description)) {
                    $success = "Category added successfully!";
                } else {
                    $error = "Failed to add category.";
                }
            } else {
                $error = "Category name is required.";
            }
        }

        $categories = $this->categoryModel->getAll();
        $pageTitle = "Category Management";
        $controller = 'category';
        $action = 'index';

        require_once 'views/layouts/header.php';
        require_once 'views/categories/index.php';
        require_once 'views/layouts/footer.php';
    }

    public function delete() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if (!empty($id)) {
            try {
                if ($this->categoryModel->delete($id)) {
                    $_SESSION['flash_success'] = "Category deleted successfully!";
                } else {
                    $_SESSION['flash_error'] = "Failed to delete category.";
                }
            } catch (PDOException $e) {
                $_SESSION['flash_error'] = "Cannot delete this category because it has active products assigned to it.";
            }
        }
        header("Location: index.php?controller=category&action=index");
        exit();
    }
}
?>