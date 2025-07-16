<?php
require_once '../models/User.php';

class LoginController {
    private $userModel;
    
    public function __construct() {
        global $conn;
        $this->userModel = new User($conn);
    }
    
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $user = $this->userModel->authenticate($username, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                
                if ($user['role'] === 'admin') {
                    header('Location: /public/index.php?page=admin/dashboard');
                } else {
                    header('Location: /public/index.php?page=user/dashboard');
                }
            } else {
                $error = "Username atau password salah";
                require_once '../app/views/login/index.php';
            }
        } else {
            require_once '../app/views/login/index.php';
        }
    }
}
?>