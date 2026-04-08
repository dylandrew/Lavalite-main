<?php
require_once __DIR__ . '/../../middlewares/AuthenticateMiddleware.php';
require_once __DIR__ . '/../../middlewares/AuthorizeMiddleware.php';
require_once __DIR__ . '/../../../scheme/helpers.php';
authenticate();
authorize();

require_once __DIR__ . '/../../../config.php';

// Initialize PDO connection from config
$dsn = DB_DRIVER . ':host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
$pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);
// ... rest of your code unchanged

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM dahd_users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Record not found!");
    }
} else {
    die("Can't find ID");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "UPDATE dahd_users SET 
            dahd_last_name = ?, 
            dahd_first_name = ?, 
            dahd_email = ?, 
            dahd_gender = ?, 
            dahd_address = ? 
            WHERE id = ?";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['ln'], 
        $_POST['fn'], 
        $_POST['em'], 
        $_POST['gn'], 
        $_POST['ad'], 
        $id
    ]);

    header("Location: " . url('users')); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akatsuki - Update Member</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('public/style.css') ?>">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0a0000, #1a0000, #0d0000);
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .wrapper { width: 100%; max-width: 520px; }

        /* Cloud stripe */
        .cloud-stripe {
            height: 8px;
            background: repeating-linear-gradient(
                90deg,
                #cc0000 0px, #cc0000 30px,
                #333 30px, #333 60px
            );
            border-radius: 8px 8px 0 0;
        }
        .cloud-stripe-bottom {
            height: 8px;
            background: repeating-linear-gradient(
                90deg,
                #cc0000 0px, #cc0000 30px,
                #333 30px, #333 60px
            );
            border-radius: 0 0 8px 8px;
        }

        /* Card */
        .card {
            background: #1a0000;
            border: 1px solid rgba(200, 0, 0, 0.5);
            border-top: none;
            border-bottom: none;
            padding: 0;
            box-shadow: 0 25px 60px rgba(180, 0, 0, 0.3);
        }

        /* Header */
        .header {
            background: #2a0000;
            border-bottom: 2px solid #cc0000;
            padding: 28px 32px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .ring-symbol {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: radial-gradient(circle, #cc0000, #600000);
            border: 2px solid #ff2200;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #ffffff;
            box-shadow: 0 0 15px rgba(200,0,0,0.5);
            flex-shrink: 0;
        }
        .header-title { color: #ffffff; font-size: 22px; font-weight: 700; }
        .header-sub { color: #ff4444; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; margin-top: 3px; }

        /* Form */
        .form-body { padding: 32px; }

        .form-group { margin-bottom: 20px; }

        label {
            display: block;
            color: #ff6666;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px 14px;
            background: #0d0000;
            border: 1px solid rgba(200, 0, 0, 0.4);
            border-radius: 8px;
            color: #ffffff;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            outline: none;
        }
        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #cc0000;
            box-shadow: 0 0 0 3px rgba(200, 0, 0, 0.2);
            background: #150000;
        }
        input::placeholder { color: #664444; }

        /* Buttons */
        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }
        .btn-update {
            flex: 1;
            padding: 13px;
            background: #7a0000;
            border: 1px solid #ff2200;
            border-radius: 8px;
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .btn-update:hover {
            background: #cc0000;
            box-shadow: 0 0 20px rgba(200,0,0,0.4);
        }
        .btn-cancel {
            flex: 1;
            padding: 13px;
            background: #1a0000;
            border: 1px solid rgba(200,0,0,0.4);
            border-radius: 8px;
            color: #ff6666;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            text-align: center;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-cancel:hover {
            background: #2a0000;
            color: #ffffff;
            border-color: #cc0000;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <div class="cloud-stripe"></div>

        <div class="card">

            <!-- Header -->
            <div class="header">
                <div class="ring-symbol">暁</div>
                <div>
                    <div class="header-title">Update Member</div>
                    <div class="header-sub">Akatsuki Organization</div>
                </div>
            </div>

            <!-- Form -->
            <div class="form-body">
                <form method="POST">
                    <?php csrf_field(); ?>

                    <div class="form-group">
                        <label for="ln">Last Name</label>
                        <input type="text" id="ln" name="ln"
                            value="<?= htmlspecialchars($user['dahd_last_name']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="fn">First Name</label>
                        <input type="text" id="fn" name="fn"
                            value="<?= htmlspecialchars($user['dahd_first_name']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="em">Email Address</label>
                        <input type="email" id="em" name="em"
                            value="<?= htmlspecialchars($user['dahd_email']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="gn">Gender</label>
                        <input type="text" id="gn" name="gn"
                            value="<?= htmlspecialchars($user['dahd_gender']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="ad">Address</label>
                        <input type="text" id="ad" name="ad"
                            value="<?= htmlspecialchars($user['dahd_address']) ?>">
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn-update">Update Member</button>
                        <a href="<?= url('users') ?>" class="btn-cancel">Cancel</a>
                    </div>

                </form>
            </div>

        </div>

        <div class="cloud-stripe-bottom"></div>

    </div>
</body>
</html>

