<?php
require_once __DIR__ . '/../models/Customer.php';

class CustomerController {
    private $customerModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        $this->customerModel = new Customer();
    }

    public function index() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $customers = $this->customerModel->getAll($search);

        $pageTitle = "Customer Management";
        $controller = 'customer';
        $action = 'index';

        require_once 'views/layouts/header.php';
        require_once 'views/customers/index.php';
        require_once 'views/layouts/footer.php';
    }

    public function create() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $phone = trim($_POST['phone']);
            $email = trim($_POST['email']);
            $address = trim($_POST['address']);

            if (!empty($name) && !empty($phone)) {
                if ($this->customerModel->create($name, $phone, $email, $address)) {
                    header("Location: index.php?controller=customer&action=index");
                    exit();
                } else {
                    $error = "Failed to add customer.";
                }
            } else {
                $error = "Name and phone number are required.";
            }
        }

        $pageTitle = "Add New Customer";
        $controller = 'customer';
        $action = 'create';

        require_once 'views/layouts/header.php';
        require_once 'views/customers/create.php';
        require_once 'views/layouts/footer.php';
    }

    public function edit() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $customer = $this->customerModel->getById($id);

        if (!$customer) {
            header("Location: index.php?controller=customer&action=index");
            exit();
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $phone = trim($_POST['phone']);
            $email = trim($_POST['email']);
            $address = trim($_POST['address']);

            if (!empty($name) && !empty($phone)) {
                if ($this->customerModel->update($id, $name, $phone, $email, $address)) {
                    header("Location: index.php?controller=customer&action=index");
                    exit();
                } else {
                    $error = "Failed to update customer.";
                }
            } else {
                $error = "Name and phone number are required.";
            }
        }

        $pageTitle = "Edit Customer";
        $controller = 'customer';
        $action = 'edit';

        require_once 'views/layouts/header.php';
        require_once 'views/customers/edit.php';
        require_once 'views/layouts/footer.php';
    }

    public function delete() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if (!empty($id)) {
            $this->customerModel->delete($id);
        }
        header("Location: index.php?controller=customer&action=index");
        exit();
    }
}
?>