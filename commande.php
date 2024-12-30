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
<form action="" method="post">
    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" required>
    
    <label for="adresse">Adresse:</label>
    <input type="text" id="adresse" name="adresse" required>
    
    <label for="telephone">Numéro de téléphone:</label>
    <input type="tel" id="telephone" name="telephone" required>
    
    <label for="moyen_paiement">Moyen de paiement:</label>
    <select id="moyen_paiement" name="moyen_paiement" required>
        <option value="orange_money">Orange Money</option>
        <option value="paypal">PayPal</option>
        <option value="mtn_money">MTN Money</option>
    </select>

    <input type="submit" value="Valider la commande">
</form>
<?php endif; ?> <!-- Fin du bloc conditionnel -->