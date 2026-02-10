<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($objet) ? 'Modifier' : 'Ajouter' ?> un objet - TAKALO</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        label {
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
            font-family: inherit;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        button, .cancel-btn {
            flex: 1;
            padding: 12px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        button[type="submit"] {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .cancel-btn {
            background: #6c757d;
            color: white;
        }

        .cancel-btn:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1><?= isset($objet) ? 'Modifier' : 'Ajouter' ?> un objet</h1>
        <form action="<?= isset($objet) ? '/objets/edit/' . $objet['id_objet'] : '/objets/create' ?>" method="POST">
            <div class="form-group">
                <label for="nom">Nom de l'objet *</label>
                <input type="text" id="nom" name="nom" value="<?= isset($objet) ? htmlspecialchars($objet['nom']) : '' ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Décrivez votre objet..."><?= isset($objet) ? htmlspecialchars($objet['description']) : '' ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="id_category">Catégorie *</label>
                    <select id="id_category" name="id_category" required>
                        <option value="">-- Sélectionner --</option>
                        <?php if (isset($categories) && count($categories) > 0): ?>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id_category'] ?>" 
                                    <?= (isset($objet) && $objet['id_category'] == $category['id_category']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['libelle']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="prix">Prix (€) *</label>
                    <input type="number" id="prix" name="prix" step="0.01" min="0" value="<?= isset($objet) ? htmlspecialchars($objet['prix']) : '0' ?>" required>
                </div>
            </div>

            <div class="button-group">
                <a href="/home" class="cancel-btn">Annuler</a>
                <button type="submit"><?= isset($objet) ? '✏️ Modifier' : '➕ Ajouter' ?></button>
            </div>
        </form>
    </div>
</body>
</html>
