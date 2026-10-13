<?php
if (!defined('BASE_URL')) {
    $h = $_SERVER['HTTP_HOST'] ?? '';
    define('BASE_URL', str_contains($h, '5300.') ? '/proxy/' . ($_SERVER['SERVER_PORT'] ?? '8080') : '');
}
$DB_HOST = 'db01.dbhost.dev';
$DB_PORT = '5051';
$DB_NAME = 'db_4559wx7c3';
$DB_USER = 'user_4559wx7c3';
$DB_PASS = 'p4559wx7c3';
$pdo = null;
try {
    $pdo = new PDO("mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 3
    ]);
} catch(PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    // Don't die - let site show login page with error
}
function getUserByEmail($email){
    global $pdo;
    if(!$pdo) return false;
    $stmt = $pdo->prepare("SELECT * FROM expense_users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch();
}
function getTxns($uid=1){
    global $pdo;
    if(!$pdo) return [];
    $stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY id DESC");
    $stmt->execute([$uid]);
    return $stmt->fetchAll();
}
function addTxn($uid, $type, $category, $amount, $date, $note){
    global $pdo;
    if(!$pdo) return false;
    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, type, category, amount, date, note) VALUES (?,?,?,?,?,?)");
    return $stmt->execute([$uid, $type, $category, $amount, $date, $note]);
}
?>
