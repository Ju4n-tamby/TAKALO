<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($category) ? 'Modifier' : 'Ajouter' ?> une catégorie</title>
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
            max-width: 500px;
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

        label {
            color: #555;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 5px;
        }

        input[type="text"] {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
    </style>
</head>
<body>
    <div class="form-container">
        <h1><?= isset($category) ? 'Modifier' : 'Ajouter' ?> une catégorie</h1>
        <form action="<?= isset($category) ? '/admin/categories/edit/' . ($category['id_category'] ?? $category['id']) : '/admin/category/new' ?>" method="POST">
            <div>
                <label for="libelle">Libellé de la catégorie :</label>
                <input type="text" id="libelle" name="libelle" value="<?= isset($category) ? htmlspecialchars($category['libelle']) : '' ?>" required autofocus>
            </div>
            <div class="button-group">
                <a href="/admin" class="cancel-btn">Annuler</a>
                <button type="submit"><?= isset($category) ? 'Modifier' : 'Ajouter' ?></button>
            </div>
        </form>
    </div>
</body>
</html>