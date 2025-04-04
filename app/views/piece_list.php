<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AutoManager - Liste des pièces</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4 text-primary">Liste des pièces</h1>
        <a href="index.php?action=add" class="btn btn-primary mb-3">➕ Ajouter une pièce</a>

        <?php
        $pieceModel = new Piece();
        $categories = $pieceModel->getCategories();
        $selectedCategory = $_GET['categorie'] ?? '';
        $search = $_GET['search'] ?? '';
        $sortField = $_GET['sort'] ?? '';
        $sortOrder = $_GET['order'] ?? 'asc';
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 5;
        ?>

        <form method="GET" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label for="categorie" class="form-label">Filtrer par catégorie :</label>
                    <select name="categorie" id="categorie" class="form-select">
                        <option value="">-- Toutes --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $selectedCategory == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="search" class="form-label">Rechercher une pièce :</label>
                    <input type="text" name="search" id="search" class="form-control" value="<?= htmlspecialchars($search) ?>" placeholder="ex : filtre, moteur...">
                </div>
                <div class="col-md-3">
                    <label for="sort" class="form-label">Trier par :</label>
                    <select name="sort" id="sort" class="form-select">
                        <option value="">-- Aucun --</option>
                        <option value="prix" <?= $sortField == 'prix' ? 'selected' : '' ?>>Prix</option>
                        <option value="stock" <?= $sortField == 'stock' ? 'selected' : '' ?>>Stock</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="order" class="form-label">Ordre :</label>
                    <select name="order" id="order" class="form-select">
                        <option value="asc" <?= $sortOrder == 'asc' ? 'selected' : '' ?>>Croissant</option>
                        <option value="desc" <?= $sortOrder == 'desc' ? 'selected' : '' ?>>Décroissant</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-primary">🔍 Appliquer</button>
                    <a href="index.php" class="btn btn-outline-secondary">↺ Réinitialiser</a>
                </div>
            </div>
        </form>

        <?php
        $allPieces = $pieceModel->getAll();

        // Filtres
        $filtered = array_filter($allPieces, function ($p) use ($selectedCategory, $search) {
            if ($selectedCategory && $p['category_id'] != $selectedCategory) return false;
            if ($search && stripos($p['nom'], $search) === false) return false;
            return true;
        });

        // Tri
        if (in_array($sortField, ['prix', 'stock'])) {
            usort($filtered, function ($a, $b) use ($sortField, $sortOrder) {
                return $sortOrder == 'asc'
                    ? $a[$sortField] <=> $b[$sortField]
                    : $b[$sortField] <=> $a[$sortField];
            });
        }

        // Pagination
        $totalItems = count($filtered);
        $totalPages = max(1, ceil($totalItems / $perPage));
        $offset = ($page - 1) * $perPage;
        $pagedPieces = array_slice($filtered, $offset, $perPage);
        ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pagedPieces as $piece): ?>
                        <tr>
                            <td><?= htmlspecialchars($piece['nom']) ?></td>
                            <td><?= htmlspecialchars($piece['description']) ?></td>
                            <td><?= htmlspecialchars($piece['prix']) ?> €</td>
                            <td>
                                <?= htmlspecialchars($piece['stock']) ?>
                                <?php if ($piece['stock'] <= 5): ?>
                                    <span class="badge bg-danger ms-2">Stock faible</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($piece['categorie'] ?? '—') ?></td>
                            <td>
                                <a href="index.php?action=edit&id=<?= $piece['id'] ?>" class="btn btn-sm btn-warning">✏️ Modifier</a>
                                <a href="index.php?action=delete&id=<?= $piece['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette pièce ?')">❌ Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav>
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                            <a class="page-link" href="<?= strtok($_SERVER['REQUEST_URI'], '?') . '?' . http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>