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

if (isset($_POST['submit'])) {
    $last = $_POST['last_name'];
    $first = $_POST['first_name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    $sql = "INSERT INTO dahd_users 
            (dahd_last_name, dahd_first_name, dahd_email, dahd_gender, dahd_address)
            VALUES (:last, :first, :email, :gender, :address)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':last'    => $last,
            ':first'   => $first,
            ':email'   => $email,
            ':gender'  => $gender,
            ':address' => $address
        ]);
        header("Location: " . url('users'));
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akatsuki - Add Member</title>
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
        .btn-save {
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
        .btn-save:hover {
            background: #cc0000;
            box-shadow: 0 0 20px rgba(200,0,0,0.4);
        }
        .btn-back {
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
        .btn-back:hover {
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
                    <div class="header-title">Add New Member</div>
                    <div class="header-sub">Akatsuki Organization</div>
                </div>
            </div>

            <!-- Form -->
            <div class="form-body">
                <form method="POST">
                    <?php csrf_field(); ?>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name"
                            placeholder="Enter last name" required>
                    </div>

                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name"
                            placeholder="Enter first name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email"
                            placeholder="Enter email" required>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <input type="text" id="gender" name="gender"
                            placeholder="Enter gender" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address"
                            placeholder="Enter address" required>
                    </div>

                    <div class="btn-group">
                        <button type="submit" name="submit" class="btn-save">
                            Add Member
                        </button>
                        <a href="<?= url('users') ?>" class="btn-back">Back</a>
                    </div>

                </form>
            </div>

        </div>

        <div class="cloud-stripe-bottom"></div>

    </div>
</body>
</html>

