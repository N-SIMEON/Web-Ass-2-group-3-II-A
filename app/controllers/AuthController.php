<?php
/**
 * AgriStack — Auth Controller
 */
class AuthController {
    private User $userModel;
    private AuditLog $audit;

    public function __construct() {
        $this->userModel = new User();
        $this->audit     = new AuditLog();
    }

    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_name']  = $user['full_name'];
                $_SESSION['user_role']  = $user['role'];
                $_SESSION['user_email'] = $user['email'];

                $this->audit->log($user['id'], $user['full_name'], 'User logged in', 'user', $user['id']);
                redirect('dashboard');
            } else {
                flash('error', 'Invalid email or password.');
            }
        }
        require_once ROOT . '/app/views/auth/login.php';
    }

    public function register(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => trim($_POST['full_name'] ?? ''),
                'email'     => trim($_POST['email'] ?? ''),
                'phone'     => trim($_POST['phone'] ?? ''),
                'password'  => $_POST['password'] ?? '',
                'role'      => in_array($_POST['role'] ?? '', ['farmer','buyer']) ? $_POST['role'] : 'farmer',
                'sector'    => trim($_POST['sector'] ?? ''),
                'coop_name' => trim($_POST['coop_name'] ?? ''),
            ];

            if (empty($data['full_name']) || empty($data['email']) || empty($data['password'])) {
                flash('error', 'Please fill in all required fields.');
            } elseif ($this->userModel->emailExists($data['email'])) {
                flash('error', 'This email is already registered.');
            } elseif (strlen($data['password']) < 6) {
                flash('error', 'Password must be at least 6 characters.');
            } else {
                $id = $this->userModel->create($data);
                if ($id) {
                    $this->audit->log($id, $data['full_name'], 'New user registered', 'user', $id);
                    flash('success', 'Account created! Please log in.');
                    redirect('login');
                } else {
                    flash('error', 'Registration failed. Please try again.');
                }
            }
        }
        require_once ROOT . '/app/views/auth/register.php';
    }

    public function logout(): void {
        if (isLoggedIn()) {
            $this->audit->log($_SESSION['user_id'], $_SESSION['user_name'], 'User logged out', 'user', $_SESSION['user_id']);
        }
        session_destroy();
        redirect('login');
    }
}
