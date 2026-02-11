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

        .optional {
            font-size: 12px;
            color: #999;
            font-weight: normal;
        }

        .image-input-wrapper {
            border: 2px dashed #667eea;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #f8f9ff;
        }

        .image-input-wrapper:hover {
            border-color: #764ba2;
            background: #f0f2ff;
        }

        .image-input-wrapper input[type="file"] {
            display: none;
        }

        .file-info {
            color: #667eea;
            font-weight: 500;
            pointer-events: none;
        }

        .image-preview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .image-preview-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .image-preview-item img {
            width: 100%;
            height: 100px;
            object-fit: cover;
        }

        .image-preview-item .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #f44336;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            font-size: 16px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-preview-item .remove-btn:hover {
            background: #d32f2f;
        }

        .existing-images {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 15px;
        }

        .image-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .image-item img {
            width: 100%;
            height: 100px;
            object-fit: cover;
        }

        .delete-image-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #f44336;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .image-item:hover .delete-image-btn {
            opacity: 1;
        }

        .delete-image-btn:hover {
            background: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1><?= isset($objet) ? 'Modifier' : 'Ajouter' ?> un objet</h1>
        <form action="<?= isset($objet) ? '/objets/edit/' . $objet['id_objet'] : '/objets/create' ?>" method="POST" enctype="multipart/form-data">
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

            <div class="form-group">
                <label for="images">Images <span class="optional">(optionnel - max 5 images de 5MB chacune)</span></label>
                <div class="image-input-wrapper">
                    <input type="file" id="images" name="images[]" multiple accept="image/*">
                    <div class="file-info">Cliquez ou glissez les images ici</div>
                </div>
                <div id="image-preview" class="image-preview"></div>
            </div>

            <?php if (isset($objet) && isset($images) && count($images) > 0): ?>
                <div class="form-group">
                    <label>Images existantes</label>
                    <div class="existing-images">
                        <?php foreach ($images as $image): ?>
                            <div class="image-item">
                                <img src="<?= htmlspecialchars($image['url']) ?>" alt="Image de l'objet">
                                <a href="/objets/delete-image/<?= $image['id_image'] ?>" class="delete-image-btn" onclick="return confirm('Supprimer cette image ?');">✕</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="button-group">
                <a href="/home" class="cancel-btn">Annuler</a>
                <button type="submit"><?= isset($objet) ? '✏️ Modifier' : '➕ Ajouter' ?></button>
            </div>
        </form>
    </div>

    <script>
        const imageInput = document.getElementById('images');
        const imagePreview = document.getElementById('image-preview');
        const imageWrapper = document.querySelector('.image-input-wrapper');

        // Click to select files
        imageWrapper.addEventListener('click', () => imageInput.click());

        // Drag and drop
        imageWrapper.addEventListener('dragover', (e) => {
            e.preventDefault();
            imageWrapper.style.borderColor = '#764ba2';
            imageWrapper.style.background = '#f0f2ff';
        });

        imageWrapper.addEventListener('dragleave', () => {
            imageWrapper.style.borderColor = '#667eea';
            imageWrapper.style.background = '#f8f9ff';
        });

        imageWrapper.addEventListener('drop', (e) => {
            e.preventDefault();
            imageInput.files = e.dataTransfer.files;
            displayImages();
        });

        // Handle file selection
        imageInput.addEventListener('change', displayImages);

        function displayImages() {
            imagePreview.innerHTML = '';
            const files = imageInput.files;
            let validCount = 0;

            for (let i = 0; i < files.length && validCount < 5; i++) {
                const file = files[i];

                // Check file type
                if (!file.type.startsWith('image/')) {
                    alert('Le fichier ' + file.name + ' n\'est pas une image');
                    continue;
                }

                // Check file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Le fichier ' + file.name + ' dépasse 5MB');
                    continue;
                }

                validCount++;
                const reader = new FileReader();

                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'image-preview-item';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Aperçu">
                        <button type="button" class="remove-btn">✕</button>
                    `;
                    div.querySelector('.remove-btn').addEventListener('click', () => {
                        div.remove();
                    });
                    imagePreview.appendChild(div);
                };

                reader.readAsDataURL(file);
            }

            if (validCount < files.length) {
                alert('Maximum 5 images de 5MB chacune');
            }
        }
    </script>
</body>
</html>
