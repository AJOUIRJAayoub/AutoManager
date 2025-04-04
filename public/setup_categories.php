<?php
require_once __DIR__ . '/../app/core/Database.php';

$db = Database::getInstance();

// Liste des catégories de base
$categories = [
    'Moteur',
    'Carrosserie',
    'Freinage',
    'Électricité',
    'Outillage',
    'Pneumatique',
    'Suspension',
];

try {
    foreach ($categories as $cat) {
        $stmt = $db->prepare("INSERT INTO categories (nom) SELECT ? FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM categories WHERE nom = ?)");
        $stmt->execute([$cat, $cat]);
    }
    echo "✅ Catégories insérées (si non existantes)";
} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
