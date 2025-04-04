<?php
if (!isset($categories)) {
    $categories = (new Piece())->getCategories();
}
?>

<!-- views/piece_form.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($piece) ? 'Modifier' : 'Ajouter' ?> une pièce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4 text-primary"><?= isset($piece) ? 'Modifier' : 'Ajouter' ?> une pièce</h1>
        <form action="index.php?action=<?= isset($piece) ? 'edit&id=' . $piece['id'] : 'add' ?>" method="POST" class="bg-white p-4 rounded shadow-sm">
            <?php if (isset($piece)): ?>
                <input type="hidden" name="id" value="<?= $piece['id'] ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label for="nom" class="form-label">Nom :</label>
                <input type="text" name="nom" id="nom" class="form-control" value="<?= $piece['nom'] ?? '' ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description :</label>
                <textarea name="description" id="description" class="form-control" required><?= $piece['description'] ?? '' ?></textarea>
            </div>

            <div class="mb-3">
                <label for="prix" class="form-label">Prix :</label>
                <input type="number" name="prix" id="prix" step="0.01" class="form-control" value="<?= $piece['prix'] ?? '' ?>" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock :</label>
                <input type="number" name="stock" id="stock" class="form-control" value="<?= $piece['stock'] ?? '' ?>" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Catégorie :</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">-- Aucune --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= isset($piece) && $piece['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success">✅ Enregistrer</button>
            <a href="index.php" class="btn btn-secondary">↩️ Retour</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>