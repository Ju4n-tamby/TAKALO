<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des Catégories</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .main-header {
            background: white;
            padding: 20px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            color: #333;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .nav-links a:hover {
            background: #f0f0f0;
        }

        .admin-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 40px;
        }

        .admin-header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-header h1 {
            color: #333;
            font-size: 32px;
        }

        .add-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            display: inline-block;
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .category-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .category-id {
            background: #f0f0f0;
            color: #666;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .category-name {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            word-break: break-word;
        }

        .category-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            flex: 1;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.3s;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-edit {
            background: #4CAF50;
            color: white;
        }

        .btn-delete {
            background: #f44336;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .empty-state {
            background: white;
            padding: 60px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .empty-state h2 {
            color: #666;
            margin-bottom: 20px;
        }

        .empty-state p {
            color: #999;
            margin-bottom: 30px;
        }

        .stats {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .categories-grid {
                grid-template-columns: 1fr;
            }

            .stats {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../../public/includes/header.php'; ?>
    
    <div class="container">
        <div class="admin-header">
            <h1>Gestion des Catégories</h1>
            <a href="/admin/categories/create" class="add-btn">+ Ajouter une catégorie</a>
        </div>

        <?php if (isset($categories) && count($categories) > 0): ?>
            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number"><?= count($categories) ?></div>
                    <div class="stat-label">Catégories totales</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">
                        <?php 
                            $totalLength = 0;
                            foreach ($categories as $cat) {
                                $totalLength += strlen($cat['libelle'] ?? '');
                            }
                            echo round($totalLength / count($categories));
                        ?>
                    </div>
                    <div class="stat-label">Caractères moyens</div>
                </div>
            </div>

            <div class="categories-grid">
                <?php foreach ($categories as $category): ?>
                    <div class="category-card">
                        <div class="category-header">
                            <span class="category-id">ID: <?= htmlspecialchars($category['id_category'] ?? $category['id'] ?? 'N/A') ?></span>
                        </div>
                        <div class="category-name">
                            <?= htmlspecialchars($category['libelle'] ?? $category['name'] ?? 'Sans nom') ?>
                        </div>
                        <div class="category-actions">
                            <a href="/admin/categories/edit/<?= $category['id_category'] ?? $category['id'] ?>" class="btn btn-edit">
                                Modifier
                            </a>
                            <button onclick="deleteCategory(<?= $category['id_category'] ?? $category['id'] ?>)" class="btn btn-delete">
                                Supprimer
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h2>Aucune catégorie trouvée</h2>
                <p>Commencez par ajouter votre première catégorie pour organiser vos objets.</p>
                <a href="/admin/categories/create" class="add-btn">+ Créer la première catégorie</a>
            </div>
        <?php endif; ?>
    </div>

    
</body>
</html>