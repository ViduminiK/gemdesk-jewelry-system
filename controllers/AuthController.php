<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    
    public function login() {
        $error = '';
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            
            if(!empty($username) && !empty($password)) {
                $userModel = new User();
                $user = $userModel->login($username, $password);
                
                if($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['full_name'] = $user['full_name'];
                    
                    header("Location: index.php?controller=dashboard&action=index");
                    exit();
                } else {
                    $error = "Invalid username or password.";
                }
            } else {
                $error = "Please fill in all fields.";
            }
        }
        
        require_once 'views/auth/login.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
        exit();
    }
}
?>