<?php
// AuthController.php
require_once 'database.php';

class AuthController {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Register a new user
 public function register($name, $contact, $email, $password) {
    try {
        $stmt = $this->pdo->prepare('SELECT id FROM customers WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Email already registered.'];
        }
        
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare('INSERT INTO customers (full_name, contact_number, email, password, role) VALUES (?, ?, ?, ?, ?)');
        $result = $stmt->execute([$name, $contact, $email, $hashed, 'customer']);
        
        if (!$result) {
            return ['success' => false, 'message' => 'Database insert failed.'];
        }
        
        $user_id = $this->pdo->lastInsertId();
        return ['success' => true, 'message' => 'Registration successful.', 'user_id' => $user_id];
    } catch (PDOException $e) {
        error_log("Registration error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}


    public function login($email, $password) {
        $stmt = $this->pdo->prepare('SELECT * FROM customers WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return [
                'success' => true, 
                'user' => [
                    'id' => $user['id'],
                    'full_name' => $user['full_name'],
                    'email' => $user['email'],
                    'contact_number' => $user['contact_number'],
                    'role' => $user['role']
                ]
            ];
        }
        return ['success' => false, 'message' => 'Invalid email or password.'];
    }

    // Logout
    public function logout() {
        session_destroy();
    }

    // Check if user is admin
    public function isAdmin() {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }
}
