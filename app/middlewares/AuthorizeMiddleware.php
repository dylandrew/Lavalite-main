<?php
if (session_status() === PHP_SESSION_NONE) session_start();

class AuthorizeMiddleware {
    public function handle() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: " . url('user-dashboard'));
            exit;
        }
    }
}

if (!function_exists('authorize')) {
    function authorize() {
        $middleware = new AuthorizeMiddleware();
        $middleware->handle();
    }
}
