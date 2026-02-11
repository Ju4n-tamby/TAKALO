<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Objets - TAKALO</title>
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
            align-items: center;
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

        .user-info-header {
            color: #667eea;
            font-weight: 600;
        }

        .logout-link {
            background: #dc3545;
            color: white !important;
        }

        .logout-link:hover {
            background: #c82333 !important;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 40px;
        }

        .page-header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h1 {
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

        .objets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .objet-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
        }

        .objet-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .objet-image-wrapper {
            width: 100%;
            height: 200px;
            background: #f0f0f0;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .objet-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .objet-image-placeholder {
            color: #999;
            font-size: 14px;
        }

        .objet-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            color: white;
        }

        .objet-name {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .objet-category {
            font-size: 14px;
            opacity: 0.9;
        }

        .objet-body {
            padding: 20px;
        }

        .objet-description {
            color: #666;
            margin-bottom: 15px;
            min-height: 60px;
            line-height: 1.5;
        }

        .objet-prix {
            font-size: 28px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 20px;
        }

        .objet-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            flex: 1;
            padding: 10px;
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
            .page-header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .objets-grid {
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
    <header class="main-header">
        <div class="logo">TAKALO</div>
        <nav class="nav-links">
            <span class="user-info-header">👤 <?= htmlspecialchars($user['username'] ?? $user['nom'] ?? 'Utilisateur') ?></span>
            <a href="/home">Mes Objets</a>
            <a href="/autre">Autre Objets</a>
            <a href="/echanges">Échanges</a>
            <?php if (isset($user) && ($user['id_type_user'] ?? 0) == 1): ?>
                <a href="/admin">Admin</a>
            <?php endif; ?>
            <a href="/deconnect" class="logout-link">Déconnexion</a>
        </nav>
    </header>

    <div class="container">
        <div class="page-header">
            <h1>Mes Objets</h1>
            <a href="/objets/create" class="add-btn">+ Ajouter un objet</a>
        </div>

        <?php if (isset($objets) && count($objets) > 0): ?>
            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number"><?= count($objets) ?></div>
                    <div class="stat-label">Objets totaux</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">
                        <?php 
                            $totalPrix = 0;
                            foreach ($objets as $obj) {
                                $totalPrix += $obj['prix'] ?? 0;
                            }
                            echo number_format($totalPrix, 2);
                        ?> €
                    </div>
                    <div class="stat-label">Valeur totale</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">
                        <?= count($objets) > 0 ? number_format($totalPrix / count($objets), 2) : 0 ?> €
                    </div>
                    <div class="stat-label">Prix moyen</div>
                </div>
            </div>

            <div class="objets-grid">
                <?php foreach ($objets as $objet): ?>
                    <div class="objet-card">
                        <div class="objet-image-wrapper">
                            <?php if (isset($objet['images']) && count($objet['images']) > 0): ?>
                                <img src="<?= htmlspecialchars($objet['images'][0]['url']) ?>" alt="<?= htmlspecialchars($objet['nom']) ?>" class="objet-image">
                            <?php else: ?>
                                <div class="objet-image-placeholder">📷 Pas d'image</div>
                            <?php endif; ?>
                        </div>
                        <div class="objet-header">
                            <div class="objet-name"><?= htmlspecialchars($objet['nom'] ?? 'Sans nom') ?></div>
                            <div class="objet-category">Catégorie ID: <?= htmlspecialchars($objet['id_category'] ?? 'N/A') ?></div>
                        </div>
                        <div class="objet-body">
                            <div class="objet-description">
                                <?= htmlspecialchars($objet['description'] ?? 'Pas de description') ?>
                            </div>
                            <div class="objet-prix">
                                <?= number_format($objet['prix'] ?? 0, 2) ?> €
                            </div>
                            <div class="objet-actions">
                                <a href="/objets/edit/<?= $objet['id_objet'] ?>" class="btn btn-edit">
                                    ✏️ Modifier
                                </a>
                                <a href="/objets/delete/<?= $objet['id_objet'] ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet objet ?');">
                                    🗑️ Supprimer
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h2>Aucun objet pour le moment</h2>
                <p>Commencez par ajouter votre premier objet à échanger.</p>
                <a href="/objets/create" class="add-btn">+ Ajouter mon premier objet</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>