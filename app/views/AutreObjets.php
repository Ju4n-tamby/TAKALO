<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objets Disponibles pour Échange - TAKALO</title>
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
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #333;
            font-size: 28px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .btn-back {
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
        }

        .btn-back:hover {
            background: #5568d3;
        }

        .objets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
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
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .objet-description {
            color: #666;
            margin-bottom: 15px;
            min-height: 60px;
            line-height: 1.5;
            flex-grow: 1;
        }

        .objet-prix {
            font-size: 28px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 15px;
        }

        .objet-owner {
            font-size: 12px;
            color: #999;
            margin-bottom: 20px;
            padding: 8px;
            background: #f5f5f5;
            border-radius: 4px;
        }

        .objet-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            flex: 1;
            padding: 12px;
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

        .btn-exchange {
            background: #28a745;
            color: white;
        }

        .btn-exchange:hover {
            opacity: 0.9;
        }

        .exchange-form {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }

        .exchange-form.active {
            display: block;
        }

        .exchange-form h4 {
            margin-bottom: 15px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #666;
            font-weight: 600;
        }

        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: inherit;
            font-size: 14px;
        }

        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: inherit;
            font-size: 14px;
            min-height: 80px;
            resize: vertical;
        }

        .exchange-actions {
            display: flex;
            gap: 10px;
        }

        .btn-submit {
            flex: 1;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: opacity 0.3s;
        }

        .btn-submit:hover {
            opacity: 0.9;
        }

        .btn-cancel-form {
            flex: 1;
            padding: 10px;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: opacity 0.3s;
        }

        .btn-cancel-form:hover {
            opacity: 0.9;
        }

        .empty-state {
            background: white;
            padding: 60px 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .empty-state h2 {
            color: #333;
            margin-bottom: 15px;
        }

        .empty-state p {
            color: #666;
            margin-bottom: 25px;
        }

        .add-btn {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background 0.3s;
        }

        .add-btn:hover {
            background: #5568d3;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
            }

            .objets-grid {
                grid-template-columns: 1fr;
            }

            .objet-card {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔄 Objets Disponibles pour Échange</h1>
            <div class="header-actions">
                <a href="/home" class="btn-back">← Mes Objets</a>
            </div>
        </div>

        <?php if (isset($objets) && count($objets) > 0): ?>
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
                            <div class="objet-owner">
                                👤 Propriétaire: <?= htmlspecialchars($objet['username'] ?? 'Utilisateur') ?>
                            </div>

                            <!-- Exchange Form -->
                            <div class="exchange-form" id="exchange-form-<?= $objet['id_objet'] ?>">
                                <h4>Proposer un échange</h4>
                                <form method="POST" action="/echange/creer">
                                    <div class="form-group">
                                        <label for="mon-objet-<?= $objet['id_objet'] ?>">Mon objet à échanger *</label>
                                        <select id="mon-objet-<?= $objet['id_objet'] ?>" name="id_mon_objet" required>
                                            <option value="">-- Sélectionner un de mes objets --</option>
                                            <?php if (isset($myObjets) && count($myObjets) > 0): ?>
                                                <?php foreach ($myObjets as $myObjet): ?>
                                                    <option value="<?= $myObjet['id_objet'] ?>">
                                                        <?= htmlspecialchars($myObjet['nom']) ?> (<?= number_format($myObjet['prix'] ?? 0, 2) ?> €)
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="" disabled>Vous n'avez pas d'objets à échanger</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="message-<?= $objet['id_objet'] ?>">Message (optionnel)</label>
                                        <textarea id="message-<?= $objet['id_objet'] ?>" name="message" placeholder="Propose un message pour cet échange..."></textarea>
                                    </div>
                                    <input type="hidden" name="id_objet_echange" value="<?= $objet['id_objet'] ?>">
                                    <div class="exchange-actions">
                                        <button type="submit" class="btn-submit">✅ Proposer l'échange</button>
                                        <button type="button" class="btn-cancel-form" onclick="cancelExchange(<?= $objet['id_objet'] ?>)">✕ Annuler</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Exchange Button -->
                            <div class="objet-actions">
                                <button class="btn btn-exchange" onclick="showExchangeForm(<?= $objet['id_objet'] ?>)">
                                    🔄 Échanger
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h2>Aucun objet disponible</h2>
                <p>Il n'y a actuellement aucun objet d'autres utilisateurs à échanger.</p>
                <a href="/home" class="add-btn">← Retour à mes objets</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Function to show exchange form
        function showExchangeForm(objetId) {
            const form = document.getElementById('exchange-form-' + objetId);
            if (form) {
                form.classList.add('active');
            }
        }

        // Function to cancel exchange form
        function cancelExchange(objetId) {
            const form = document.getElementById('exchange-form-' + objetId);
            if (form) {
                form.classList.remove('active');
            }
        }

        // Close exchange form when clicking outside
        document.addEventListener('click', function(event) {
            const forms = document.querySelectorAll('.exchange-form.active');
            forms.forEach(form => {
                if (!form.contains(event.target) && !event.target.closest('.btn-exchange')) {
                    form.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
