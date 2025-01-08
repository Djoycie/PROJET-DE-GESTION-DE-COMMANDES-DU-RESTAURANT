<?php
require_once 'database.php';

// Récupère toutes les commandes
$sql = "SELECT * FROM commandes";
$result = $conn->query($sql);
echo "<style>
    body {
        background-image: url('images/c9.jpg'); /* Remplace par le chemin de ton image */
        background-size: cover; /* Pour couvrir toute la page */
        background-repeat: no-repeat; /* Pour éviter la répétition de l'image */
        background-attachment: fixed; /* Pour que l'image reste fixe lors du défilement */
        color: white; /* Change la couleur du texte si nécessaire pour plus de lisibilité */
        backdrop-filter:blur(5px);
    }
</style>";

if ($result && $result->num_rows > 0) {
    echo "<h1 style='text-align:center; color:tomato; text-decoration:underline;'>Historiques des commandes des clients</h1>";
    echo "<table border='1' style='color:black; margin-top:100px;margin-right: 90px; margin-left: 100px; border-collapse: collapse;'>"; // Ajout d'un tableau sans marges et avec collapse
    echo "<tr>
            <th style='background-color:#f6d7d2; padding: 5px;'>Commande ID</th>
            <th style='background-color:#f6d7d2; padding: 5px;'>Nom</th>
            <th style='background-color:#f6d7d2; padding: 5px;'>Adresse</th>
            <th style='background-color:#f6d7d2; padding: 5px;'>Téléphone</th>
            <th style='background-color:#f6d7d2; padding: 5px;'>Moyen de paiement</th>
            <th style='background-color:#f6d7d2; padding: 5px;'>Articles</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr style=' background-color:rgba(255,255,255,0.5);'>";
        echo "<td style='background-color:#f6d7d2; padding: 5px;'>" . htmlspecialchars($row["id"]) . "</td>";
        echo "<td style='padding: 5px;'>" . htmlspecialchars($row["nom"]) . "</td>";
        echo "<td style='padding: 5px;'>" . htmlspecialchars($row["adresse"]) . "</td>";
        echo "<td style='padding: 5px;'>" . htmlspecialchars($row["telephone"]) . "</td>";
        echo "<td style='padding: 5px;'>" . htmlspecialchars($row["moyen_paiement"]) . "</td>";
        echo "<td style='padding: 5px;'>" . nl2br(htmlspecialchars($row["articles"])) . "</td>"; // Utilisation de nl2br pour les retours à la ligne dans les articles
        echo "</tr>";
    }
    
    echo "</table>"; // Fermeture du tableau
} else {
    echo "Aucune commande trouvée";
}
?>