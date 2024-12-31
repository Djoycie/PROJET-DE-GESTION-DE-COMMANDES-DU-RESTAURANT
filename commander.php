<?php
require_once 'database.php';

// Récupère toutes les commandes
$sql = "SELECT * FROM commandes";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<h1 style='text-align:center;'>Historiques des commandes des clients</h1>";
    echo "<table border='1' style='margin-right: 100px; margin-left: 100px; border-collapse: collapse;'>"; // Ajout d'un tableau sans marges et avec collapse
    echo "<tr>
            <th style='background-color:skyblue; padding: 5px;'>Commande ID</th>
            <th style='background-color:skyblue; padding: 5px;'>Nom</th>
            <th style='background-color:skyblue; padding: 5px;'>Adresse</th>
            <th style='background-color:skyblue; padding: 5px;'>Téléphone</th>
            <th style='background-color:skyblue; padding: 5px;'>Moyen de paiement</th>
            <th style='background-color:skyblue; padding: 5px;'>Articles</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='background-color:skyblue; padding: 5px;'>" . htmlspecialchars($row["id"]) . "</td>";
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