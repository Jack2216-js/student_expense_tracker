<?php
session_start();
require __DIR__ . '/config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$uid = $_SESSION['user_id'];

try {
    global $pdo;

    // Check pdo irukka nu
    if (!isset($pdo)) {
        die("Database connection illa da Jack!");
    }

    // Ellam transaction um delete pannidum - un user_id ku mattum
    $stmt = $pdo->prepare("DELETE FROM transactions WHERE user_id = ?");
    $stmt->execute([$uid]);

    // Dashboard ku thirumba anuppidum
    header("Location: dashboard.php");
    exit;

} catch (Exception $e) {
    die("Delete failed da Jack: " . $e->getMessage());
}
?>