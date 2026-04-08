<?php
require_once __DIR__ . '/../../middlewares/AuthenticateMiddleware.php';
require_once __DIR__ . '/../../middlewares/AuthorizeMiddleware.php';
require_once __DIR__ . '/../../../scheme/helpers.php';
authenticate();
authorize();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        db()->table('dahd_users')->where('id', $id)->delete();
    }
}

header("Location: " . url('users'));
exit;
