
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
        *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Monsterrat', Times, sans-serif, ;
    }
    
    body {
        background-image: radial-gradient(circle, #f9ecec, #fae8e4, #f6d7d2, #f0f2d2); 
        backdrop-filter: blur(5px);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        height: 100%;
        font-family: 'Monsterrat';
    }
      
        .container {   
        width: 368px;
        max-width: 100%;
        overflow: hidden;
        display: flex;
        margin:  50px ;
        padding: 20px;
        position: relative;
        background-color: #fff;
        border-radius: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        }

        .header-container {
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin-bottom: 20px; 
           }
   
   
       .logo {
            max-width: 68px; 
            height: auto;
            margin-bottom: 0px; 
        }
    
        .container p{
            font-size: 14px;
            line-height: 20px;
            letter-spacing: 0.3px;
            margin: 20px 0;
        }
    
        .container span{
            font-family: Arial, Helvetica, sans-serif;
            padding: 50px;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }
    
        .container a{
            color: tomato;
            font-size: 13px;
            text-decoration: none;
            margin: 15px 0 10px;
        }
    
        .social-icons{
            font-size: 13px;
            margin: 25px 0 15px;
            margin-left: 15px;
        }
    
        
        
        #form-connexion {
        margin-top: 20px;
        
        }
    
        .form{
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }
        
        label {
        display: block;
        font-family: 'Geneva', Tahoma, Geneva, Verdana, sans-serif;
        margin-top: 10px;
        margin-bottom: 10px;
        }
        
       input[type="text"], input[type="number"] {
            width: 100%;
            height: 35px;
            font-size: 12px;
            margin-top: 10px;
            margin-bottom: 10px;
            padding: 10px 15px;
            border: none;
            border-radius: 50px;
            background-color: #eee;
            outline: none;
        }
        .button{
            
        }
        
        button[type="submit"] {
        width: 70%;
        height: 40px;
        background-color: tomato;
        color: #fff;
        font-size: 12px;
        padding: 10px;
        border: 1px solid transparent;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        text-align: center;
        border-radius: 8px;
        margin-top: 30px;
        margin-left: 45px;
        display:block;
        flex-direction: column;
        align-items: center; 
        justify-content: center;
        margin-bottom: 30px;
        cursor: pointer;
        }
        
        button[type="submit"]:hover {
        background-color: rgb(248, 127, 106);
        }
    
        .question{
            margin-left: 35px;
            margin-top: 25px;
            margin-bottom: 10px;
            text-decoration: underline;
            text-decoration-color: tomato;
        }
    
        h1{
        text-align: center;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        color:tomato;
        margin-top: 20px;
        margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Modifier le menu</h1>
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
</body>
</html>


