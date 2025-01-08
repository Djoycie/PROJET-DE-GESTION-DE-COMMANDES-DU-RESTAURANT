
<?php
// Connexion à la base de données
require_once 'database.php';

// Récupérer l'article depuis la base de données
$article = $_POST['article'];

// Fonction pour mettre à jour les informations de l'article
function updateArticle($conn, $article) {
    // Vérifier si les champs obligatoires sont remplis
    if (isset($_POST['nom']) && isset($_POST['description']) && isset($_POST['prix']) && isset($_POST['categorie'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $description = htmlspecialchars($_POST['description']);
        $prix = htmlspecialchars($_POST['prix']);
        $categorie = htmlspecialchars($_POST['categorie']);

        // Garde l'ancienne image par défaut
        $image = $article['image'];

        // Vérifie si un fichier image a été téléchargé
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Traiter le fichier image ici
            $uploadDir = 'images/';
            $imageFileName = basename($_FILES['image']['name']);
            $uploadFilePath = $uploadDir . $imageFileName;

            // Déplace le fichier téléchargé dans le répertoire souhaité
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFilePath)) {
                // Si le déplacement est réussi, mettre à jour le nom de l'image
                $image = $imageFileName;
            } else {
                // Gérer une erreur lors du déplacement du fichier si nécessaire
                echo "Erreur lors du téléchargement de l'image.";
            }
        }

        // Mettre à jour les informations de l'article dans la base de données
        $sql = "UPDATE menus SET nom = ?, description = ?, prix = ?, categorie = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nom, $description, $prix, $categorie, $image, $article['id']);
        $stmt->execute();
        $stmt->close();

        // Rediriger vers la page de gestion des articles
        header("Location: afficher_menu.php");
        exit;
    }
}

// Appeler la fonction pour mettre à jour les informations de l'article
updateArticle($conn, $article);

// Affiche les informations de l'article dans des champs de saisie
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'article</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
    background-size: cover;
    background-image: url(imgs/img-fond1.jpg);
    backdrop-filter: blur(5px);
    }
        
        
        h1 {
            text-align: center;
            color: white;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type='text'],
        input[type='number'],
        textarea,
        select {
            width: 94%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        input[type='file'] {
            margin-bottom: 15px;
        }
        input[type='submit'] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin:0 auto;
            display:block;
            
        }
        input[type='submit']:hover {
            background-color: #218838;
           
        }
        form{
            border: 2px solid green;
  padding: 20px;
  width: 350px;
  margin: 20px auto;
  background-color: #f9f9f9;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
   border-radius:10px;

        }
        
    </style>
</head>
<body>
<div class="container">
        <div class="header-container">
          <img src="images/food logo.png" alt="Restaurant Logo" class="logo">
        <h1>Modifier le menu</h1>
        </div>
        <form method='post' action='' enctype='multipart/form-data'>
            <!-- Ajoute enctype pour les fichiers -->
            <label for='nom'>Nom :</label>
            <input type='text' id='nom' name='nom' value='<?php echo htmlspecialchars($article['nom']); ?>'>
            <br>
            <label for='description'>Description :</label>
            <textarea id='description' name='description'><?php echo htmlspecialchars($article['description']); ?></textarea>
            <br>
            <label for='prix'>Prix :</label>
            <input type='number' id='prix' name='prix' value='<?php echo htmlspecialchars($article['prix']); ?>'>
            <br>
            <label for='categorie'>Catégorie :</label>
            <select id='categorie' name='categorie'>
                <option value='<?php echo htmlspecialchars($article['categorie']); ?>'><?php echo htmlspecialchars($article['categorie']); ?></option>
                <!-- Ajouter d'autres options pour les catégories ici -->
            </select>
            <br>
            <label for='image'>Image :</label>
            <input type='file' id='image' name='image'>
            <br>
            <input type='submit' value='Valider les modifications'>
        </form>
    </div>
    </body>
</html>


