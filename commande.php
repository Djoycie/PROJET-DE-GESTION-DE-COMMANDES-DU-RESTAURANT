<?php
session_start();
require_once 'database.php';

$commande_validee = false; // Variable pour vérifier si la commande est validée

// Vérifiez si le panier n'est pas vide
if (!isset($_SESSION["panier"]) || count($_SESSION["panier"]) == 0) {
    echo "<h2>Le panier est vide. Vous ne pouvez pas passer de commande.</h2>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les informations de l'utilisateur en vérifiant si elles existent
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
    $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
    $moyen_paiement = isset($_POST['moyen_paiement']) ? $_POST['moyen_paiement'] : '';

    // Vérification que toutes les informations requises sont présentes
    if ($nom && $adresse && $telephone && $moyen_paiement) {
        // Insérer la commande dans la base de données
        $sql = "INSERT INTO commandes (nom, adresse, telephone, moyen_paiement, articles) VALUES (?, ?, ?, ?, ?)";
        
        // Convertir le panier en format JSON pour l'enregistrer
        $articles_json = json_encode($_SESSION["panier"]);

        // Préparer et exécuter la requête
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssss", $nom, $adresse, $telephone, $moyen_paiement, $articles_json);
            if ($stmt->execute()) {
                echo "<h2>Commande validée avec succès ! Merci pour votre achat.</h2>";
                header("Refresh: 1; URL=index.php");
exit();
                // Réinitialiser le panier
                unset($_SESSION["panier"]);
                $_SESSION["prix_total"] = 0;
                $commande_validee = true; // Met à jour la variable pour indiquer que la commande est validée
            } else {
                echo "<h2>Erreur lors de la validation de la commande.</h2>";
            }
            $stmt->close();
        }
    } else {
        echo "<h2></h2>";
    }
}

// Formulaire pour entrer les informations de la commande
?>

<?php if (!$commande_validee): ?> <!-- Affiche le formulaire seulement si la commande n'est pas validée -->
    <h1>Passer une commande</h1>
    <div class="form-container">
    
    <form action="" method="post">
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        
        <div class="form-group">
            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse" required>
        </div>
        
        <div class="form-group">
            <label for="telephone">Numéro de téléphone:</label>
            <input type="tel" id="telephone" name="telephone" required>
        </div>
        
        <div class="form-group">
            <label for="moyen_paiement">Moyen de paiement:</label>
            <select id="moyen_paiement" name="moyen_paiement" required>
                <option value="orange_money">Orange Money</option>
                <option value="paypal">PayPal</option>
                <option value="mtn_money">MTN Money</option>
            </select>
        </div>

        <input type="submit" value="Valider la commande" class="submit-button">
    </form>
</div>
<?php endif; ?> <!-- Fin du bloc conditionnel -->

<style>
    body {
    font-family: 'Times New Roman', Times, serif;
    background-size: cover;
    background-image: url(imgs/img-fond1.jpg);
    backdrop-filter: blur(5px);
    }

    .form-container {
    max-width: 400px;
    margin: 50px auto; /* Centre le conteneur */
    padding: 20px;
    border: 2px solid green; /* Bordure grise */
    border-radius: 8px; /* Coins arrondis */
    background-color: #f9f9f9; /* Fond léger */
    box-shadow: 0 2px 10px rgba(83, 228, 119, 0.1); /* Ombre légère */
}

.form-group {
    margin-bottom: 25px; /* Espace entre les champs */
}

.form-group label {
    display: block; /* Étiquette sur une nouvelle ligne */
    margin-bottom: 5px; /* Espace sous l'étiquette */
}

.form-group input,
.form-group select {
    width: 100%; /* Largeur complète */
    padding: 10px; /* Espacement intérieur */
    border: 1px solid #ccc; /* Bordure grise */
    border-radius: 5px; /* Coins arrondis */
}

.submit-button {
    background-color: green; /* Couleur du bouton */
    color: white; /* Texte en blanc */
    border: none; /* Pas de bordure */
    padding: 10px;
    width: 50%; /* Largeur complète */
    font-size: 16px;
    cursor: pointer; /* Curseur pointeur au survol */
    border-radius:10px;
    transform:translate(50%,-50%);
    top:50%;
    left:50%;
    margin-top:50px;
}

.submit-button:hover {
    background-color: darkgreen; /* Couleur plus foncée au survol */
}

h1{
    text-align:center;
    color:white;
    margin-top:35px;
}
    </style>