<?php
// Start session for authentication and flash messages
session_start();

// Basic Router
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Map controller names to actual class files
switch ($controller) {
    case 'auth':
        require_once 'controllers/AuthController.php';
        $ctrl = new AuthController();
        break;
    case 'dashboard':
        require_once 'controllers/DashboardController.php';
        $ctrl = new DashboardController();
        break;
    case 'category':
        require_once 'controllers/CategoryController.php';
        $ctrl = new CategoryController();
        break;
    case 'product':
        require_once 'controllers/ProductController.php';
        $ctrl = new ProductController();
        break;
    case 'customer':
        require_once 'controllers/CustomerController.php';
        $ctrl = new CustomerController();
        break;
    case 'sales':
        require_once 'controllers/SalesController.php';
        $ctrl = new SalesController();
        break;
    default:
        // Redirect to login if controller not found
        header("Location: index.php?controller=auth&action=login");
        exit();
}

// Call the requested method if it exists
if (method_exists($ctrl, $action)) {
    $ctrl->$action();
} else {
    echo "Page not found!";
}
?>