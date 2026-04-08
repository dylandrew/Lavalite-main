<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: " . url($_SESSION['role'] === 'admin' ? 'users' : 'user-dashboard'));
    exit;
}

$error = '';

// Define accounts here
$accounts = [
    'admin'   => ['password' => 'admin123', 'role' => 'admin'],
    'dylan'   => ['password' => 'dylan123', 'role' => 'user'],
    'andrew'  => ['password' => 'andrew123', 'role' => 'user'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (isset($accounts[$username]) && $accounts[$username]['password'] === $password) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username']  = $username;
        $_SESSION['role']      = $accounts[$username]['role'];

        header("Location: " . url($_SESSION['role'] === 'admin' ? 'users' : 'user-dashboard'));
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Akatsuki - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0a0000, #1a0000, #0d0000);
            font-family: 'Inter', sans-serif;
            display: flex; align-items: center; justify-content: center;
            padding: 40px 20px;
        }
        .wrapper { width: 100%; max-width: 420px; }
        .cloud-stripe {
            height: 8px;
            background: repeating-linear-gradient(90deg, #cc0000 0px, #cc0000 30px, #333 30px, #333 60px);
            border-radius: 8px 8px 0 0;
        }
        .cloud-stripe-bottom {
            height: 8px;
            background: repeating-linear-gradient(90deg, #cc0000 0px, #cc0000 30px, #333 30px, #333 60px);
            border-radius: 0 0 8px 8px;
        }
        .card {
            background: #1a0000;
            border: 1px solid rgba(200,0,0,0.5);
            border-top: none; border-bottom: none;
            box-shadow: 0 25px 60px rgba(180,0,0,0.3);
        }
        .header {
            background: #2a0000; border-bottom: 2px solid #cc0000;
            padding: 28px 32px; display: flex; align-items: center; gap: 16px;
        }
        .ring-symbol {
            width: 48px; height: 48px; border-radius: 50%;
            background: radial-gradient(circle, #cc0000, #600000);
            border: 2px solid #ff2200;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: #fff;
            box-shadow: 0 0 15px rgba(200,0,0,0.5);
        }
        .header-title { color: #fff; font-size: 22px; font-weight: 700; }
        .header-sub { color: #ff4444; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; margin-top: 3px; }
        .form-body { padding: 32px; }
        .form-group { margin-bottom: 20px; }
        label {
            display: block; color: #ff6666;
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;
        }
        input[type="text"], input[type="password"] {
            width: 100%; padding: 12px 14px;
            background: #0d0000;
            border: 1px solid rgba(200,0,0,0.4);
            border-radius: 8px; color: #fff;
            font-size: 14px; font-family: 'Inter', sans-serif;
            outline: none; transition: all 0.2s;
        }
        input:focus {
            border-color: #cc0000;
            box-shadow: 0 0 0 3px rgba(200,0,0,0.2);
            background: #150000;
        }
        input::placeholder { color: #664444; }
        .error {
            background: rgba(200,0,0,0.15);
            border: 1px solid #cc0000;
            color: #ff6666; padding: 10px 14px;
            border-radius: 8px; font-size: 13px;
            margin-bottom: 20px;
        }
        .btn-login {
            width: 100%; padding: 13px;
            background: #7a0000;
            border: 1px solid #ff2200;
            border-radius: 8px; color: #fff;
            font-size: 13px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1px;
            cursor: pointer; transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .btn-login:hover { background: #cc0000; box-shadow: 0 0 20px rgba(200,0,0,0.4); }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="cloud-stripe"></div>
        <div class="card">
            <div class="header">
                <div class="ring-symbol">暁</div>
                <div>
                    <div class="header-title">Akatsuki Login</div>
                    <div class="header-sub">Members Only Access</div>
                </div>
            </div>
            <div class="form-body">
                <?php if (!empty($error)): ?>
                    <div class="error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST">
                    <?php csrf_field(); ?>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username"
                            value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            placeholder="Enter username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password"
                            placeholder="Enter password" required>
                    </div>
                    <button type="submit" class="btn-login">Login</button>
                </form>
            </div>
        </div>
        <div class="cloud-stripe-bottom"></div>
    </div>
</body>
</html>

