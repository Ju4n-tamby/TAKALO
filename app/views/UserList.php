<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs - TAKALO</title>
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

        .back-btn {
            background: #6c757d;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s;
            display: inline-block;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            background: #5a6268;
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

        .user-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .user-section h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #667eea;
        }

        .user-section h2 .badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            margin-left: 10px;
            vertical-align: middle;
        }

        .admin-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .user-badge {
            background: #28a745;
            color: white;
        }

        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .user-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .user-info {
            margin-bottom: 15px;
        }

        .user-info .label {
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .user-info .value {
            color: #333;
            font-size: 18px;
            font-weight: 600;
        }

        .user-id {
            background: #e9ecef;
            color: #495057;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .users-grid {
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
        <div class="page-header">
            <h1>Liste des Utilisateurs</h1>
            <a href="/admin" class="back-btn">← Retour Admin</a>
        </div>

        <?php if (isset($users) && count($users) > 0): ?>
            <?php
                // Séparer les utilisateurs par type
                $admins = array_filter($users, function($user) {
                    return ($user['id_type_user'] ?? 0) == 1;
                });
                $regularUsers = array_filter($users, function($user) {
                    return ($user['id_type_user'] ?? 0) != 1;
                });
            ?>

            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number"><?= count($users) ?></div>
                    <div class="stat-label">Utilisateurs totaux</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?= count($admins) ?></div>
                    <div class="stat-label">Administrateurs</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?= count($regularUsers) ?></div>
                    <div class="stat-label">Utilisateurs standards</div>
                </div>
            </div>

            <?php if (count($admins) > 0): ?>
                <div class="user-section">
                    <h2>
                        Administrateurs
                        <span class="badge admin-badge"><?= count($admins) ?></span>
                    </h2>
                    <div class="users-grid">
                        <?php foreach ($admins as $user): ?>
                            <div class="user-card">
                                <span class="user-id">ID: <?= htmlspecialchars($user['id_user'] ?? $user['id'] ?? 'N/A') ?></span>
                                <div class="user-info">
                                    <div class="label">Nom d'utilisateur</div>
                                    <div class="value"><?= htmlspecialchars($user['nom'] ?? $user['username'] ?? 'Inconnu') ?></div>
                                </div>
                                <?php if (isset($user['email'])): ?>
                                    <div class="user-info">
                                        <div class="label">Email</div>
                                        <div class="value"><?= htmlspecialchars($user['email']) ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (count($regularUsers) > 0): ?>
                <div class="user-section">
                    <h2>
                        Utilisateurs Standards
                        <span class="badge user-badge"><?= count($regularUsers) ?></span>
                    </h2>
                    <div class="users-grid">
                        <?php foreach ($regularUsers as $user): ?>
                            <div class="user-card">
                                <span class="user-id">ID: <?= htmlspecialchars($user['id_user'] ?? $user['id'] ?? 'N/A') ?></span>
                                <div class="user-info">
                                    <div class="label">Nom d'utilisateur</div>
                                    <div class="value"><?= htmlspecialchars($user['nom'] ?? $user['username'] ?? 'Inconnu') ?></div>
                                </div>
                                <?php if (isset($user['email'])): ?>
                                    <div class="user-info">
                                        <div class="label">Email</div>
                                        <div class="value"><?= htmlspecialchars($user['email']) ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="user-section">
                <div class="empty-state">
                    <h2>Aucun utilisateur trouvé</h2>
                    <p>La base de données ne contient aucun utilisateur pour le moment.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>