<?php
session_start();
require __DIR__ . '/config/database.php';
$uid = $_SESSION['uid'] ?? $_SESSION['user_id'] ?? null;
if (!$uid) { header('Location: login.php'); exit; }
try {
    $stmt = $pdo->prepare("DELETE FROM transactions WHERE user_id = ?");
    $stmt->execute([$uid]);
    header("Location: dashboard.php");
    exit;
} catch (Exception $e) {
    die("Delete failed: " . $e->getMessage());
}
?>
