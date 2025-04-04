<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
?>

<!-- index.php -->
<?php
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/models/Piece.php';
require_once __DIR__ . '/../app/controllers/PieceController.php';


$controller = new PieceController();
$controller->handleRequest();
?>
