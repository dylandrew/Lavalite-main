<?php
if (session_status() === PHP_SESSION_NONE) session_start();

class AuthenticateMiddleware {
    public function handle() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header("Location: " . url('login'));
            exit;
        }
    }
}

if (!function_exists('authenticate')) {
    function authenticate() {
        $middleware = new AuthenticateMiddleware();
        $middleware->handle();
    }
}
