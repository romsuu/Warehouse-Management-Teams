<?php
session_start();
require_once 'php/db.php';
require_once 'php/language.php';

// Redirect user to Admin Panel if already logged in
if (isset($_SESSION['user'])) {
    header("Location: php/adminPanel.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'en' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= translate('login') ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1><?= translate('welcome') ?></h1>
    <form action="php/login.php" method="POST">
        <label for="pincode"><?= translate('pincode_required') ?></label>
        <input type="text" id="pincode" name="pincode" required>
        <button type="submit"><?= translate('login') ?></button>
    </form>
    <p>
        <a href="index.php?lang=en">English</a> |
        <a href="index.php?lang=ru">Русский</a> |
        <a href="index.php?lang=et">Eesti</a>
    </p>
</body>
</html>
