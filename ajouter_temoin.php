<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    // Récupérer les données du formulaire et échapper les caractères spéciaux
    $temoignage = htmlspecialchars($_REQUEST['temoignage']);
  
    // Vérifier si le champ témoignage est rempli
    if (!empty($temoignage)) {
        // Préparer la requête pour éviter les injections SQL
        $stmt = $conn->prepare("INSERT INTO temoignage (temoignage) VALUES (?)");
        $stmt->bind_param("s", $temoignage);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Témoignage enregistré avec succès.";
            header('Location: index.php');
            exit;
        } else {
            echo "Erreur : insertion des données impossible.";
        }

        // Fermer la déclaration
        $stmt->close();
    } else {
        echo "Erreur : champ témoignage non rempli.";
    }
} else {
    echo "Erreur : méthode de requête non prise en charge.";
}

// Fermer la connexion à la base de données
$conn->close();
?>