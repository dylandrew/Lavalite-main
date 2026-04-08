<?php
require_once __DIR__ . '/../../middlewares/AuthenticateMiddleware.php';
require_once __DIR__ . '/../../../scheme/helpers.php';
authenticate();

$users = db()->table('dahd_users')->get_all();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Akatsuki - Members</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0a0000, #1a0000, #0d0000);
            font-family: 'Inter', sans-serif;
            padding: 40px 20px;
        }
        .wrapper { max-width: 1100px; margin: 0 auto; }
        .cloud-stripe {
            height: 8px;
            background: repeating-linear-gradient(90deg, #cc0000 0px, #cc0000 30px, #333 30px, #333 60px);
            border-radius: 8px 8px 0 0;
        }
        .card {
            background: #1a0000;
            border: 1px solid rgba(200, 0, 0, 0.5);
            border-top: none;
            border-radius: 0 0 16px 16px;
            padding: 32px;
            box-shadow: 0 25px 60px rgba(180, 0, 0, 0.3);
        }
        .header {
            display: flex; align-items: center; justify-content: space-between;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(200, 0, 0, 0.4);
            margin-bottom: 24px;
        }
        .header-left { display: flex; align-items: center; gap: 16px; }
        .ring-symbol {
            width: 52px; height: 52px; border-radius: 50%;
            background: radial-gradient(circle, #cc0000, #600000);
            border: 2px solid #ff2200;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: #ffffff;
            box-shadow: 0 0 15px rgba(200,0,0,0.5);
        }
        .header-title { color: #ffffff; font-size: 26px; font-weight: 700; }
        .header-sub { color: #ff4444; font-size: 12px; letter-spacing: 2px; text-transform: uppercase; margin-top: 4px; }
        .btn-logout {
            padding: 8px 20px;
            background: #3a0000;
            border: 1px solid #cc0000;
            border-radius: 8px; color: #ff6666;
            font-size: 13px; font-weight: 700;
            text-decoration: none; transition: all 0.2s;
        }
        .btn-logout:hover { background: #990000; color: #fff; }
        .table-wrap { border-radius: 10px; overflow: hidden; border: 1px solid rgba(200,0,0,0.4); }
        table { width: 100%; border-collapse: collapse; text-align: center; font-size: 14px; }
        thead tr { background: #3a0000; }
        thead th { padding: 14px 12px; color: #ff6666; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 12px; }
        tbody tr { border-top: 1px solid rgba(200,0,0,0.2); transition: background 0.15s; }
        tbody tr:hover { background: #2a0000; }
        tbody td { padding: 13px 12px; color: #ffffff; font-size: 14px; font-weight: 500; }
        .cloud-stripe-bottom {
            height: 8px;
            background: repeating-linear-gradient(90deg, #cc0000 0px, #cc0000 30px, #333 30px, #333 60px);
            border-radius: 0 0 8px 8px; margin-top: 32px;
        }
        .empty { color: #ff6666; padding: 40px; font-style: italic; font-size: 16px; }
        .badge {
            background: #3a0000; border: 1px solid #cc0000;
            color: #ff6666; font-size: 11px; font-weight: 700;
            padding: 4px 10px; border-radius: 20px;
            text-transform: uppercase; letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="cloud-stripe"></div>
        <div class="card">

            <div class="header">
                <div class="header-left">
                    <div class="ring-symbol">暁</div>
                    <div>
                        <div class="header-title">Akatsuki Members</div>
                        <div class="header-sub">View Only — <?= htmlspecialchars($_SESSION['username'] ?? 'User', ENT_QUOTES, 'UTF-8') ?></div>
                    </div>
                </div>
                <a href="<?= url('logout') ?>" class="btn-logout">Logout</a>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                        <tr><td colspan="6" class="empty">No members found.</td></tr>
                        <?php else: ?>
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($user['dahd_last_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($user['dahd_first_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($user['dahd_email'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($user['dahd_gender'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($user['dahd_address'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="cloud-stripe-bottom"></div>
        </div>
    </div>
</body>
</html>
