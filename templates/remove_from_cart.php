<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../action/action_login.php');
    exit;
}
if (isset($_GET['item_id'])) {
    $pdo = new PDO('sqlite:../database/database.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("DELETE FROM Cart WHERE item_id = ? AND user_id = ?");
    $stmt->execute([$_GET['item_id'], $_SESSION['user_id']]);
    header('Location: shopping_cart.php');
    exit;
}
?>
