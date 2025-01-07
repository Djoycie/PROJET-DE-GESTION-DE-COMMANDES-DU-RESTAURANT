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


   
    <div class="image-container">
        <header>
            <div class="logo">Mama'Kitchen</div>
           
        </header>
        <h2>Bienvenue chez Mama'Kitchen</h2>
        <h3></h3>
        <h4>Souhaitez-vous passer une commande?  Vous êtes au bon endroit.</h4>
    </div>
    <div class="grid-container">
        <div class="form-container">
            <h1>Passer une commande</h1>
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
    </div>
<?php endif; ?> <!-- Fin du bloc conditionnel -->

<style>
    body {
    background-image: radial-gradient(circle, #f9ecec, #fae8e4, #f6d7d2, hsl(64, 55%, 89%)); 
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    height: 100%;
    font-family: 'Montserrat', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.image-container {
    width: 105%;
    height: 200%;
    background-image: url(images/cocktail.jpg);
    background-size: cover;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
    text-align: center;
    color: white;
}

header {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    position: absolute;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.5); /* Optional semi-transparent background */
}

header .logo {
    font-size: 1.5em;
    font-weight: bold;
    color: white;
}

nav ul {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
}

nav ul li {
    margin-left: 20px;
}

nav ul li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
}

h2, h3, h4 {
    margin: 70px 0;
}

.grid-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    padding: 20px;
}

.form-container {
    width: 70%;
    height: auto;
    overflow: hidden;
    display: flex;
    margin: 50px;
    padding: 30px;
    position: relative;
    background-color: #fff;
    border-radius: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
    flex-direction: column;
    align-items: normal;
    justify-content: flex-start;
}

.form-group {
    width: 100%;
    margin-bottom: 25px; /* Espace entre les champs */
}

.form-group label {
    display: block; /* Étiquette sur une nouvelle ligne */
    margin-bottom: 5px; /* Espace sous l'étiquette */
    font-family: Georgia, 'Times New Roman', Times, serif;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 10px; /* Espacement intérieur */
    border: 1px solid #ccc; /* Bordure grise */
    border-radius: 5px; /* Coins arrondis */
}

.submit-button {
    background-color: tomato; /* Couleur du bouton */
    color: white; /* Texte en blanc */
    border: none; /* Pas de bordure */
    padding: 10px;
    width: 50%; /* Largeur */
    font-size: 16px;
    cursor: pointer; /* Curseur pointeur au survol */
    border-radius: 10px;
    margin: 30px auto 20px auto; /* Centrer le bouton */
    display: block;
}

.submit-button:hover {
    background-color: rgb(248,127,106); /* Couleur plus foncée au survol */
}

h1 {
    text-align: center;
    text-decoration: underline;
    color: tomato;
    margin-top: 35px;
    margin-bottom: 20px;
}

</style>