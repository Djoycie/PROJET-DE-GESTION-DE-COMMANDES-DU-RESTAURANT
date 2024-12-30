<?php
require_once 'database.php';

// Récupère toutes les commandes
$sql = "SELECT * FROM commandes";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<h1>Historiques des commandes des clients</h1>";
    echo "<table border='1'>"; // Ajout d'un tableau avec une bordure
    echo "<tr>
            <th>Commande ID</th>
            <th>Nom</th>
            <th>Adresse</th>
            <th>Téléphone</th>
            <th>Moyen de paiement</th>
            <th>Articles</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["nom"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["adresse"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["telephone"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["moyen_paiement"]) . "</td>";
        echo "<td>" . nl2br(htmlspecialchars($row["articles"])) . "</td>"; // Utilisation de nl2br pour les retours à la ligne dans les articles
        echo "</tr>";
    }
    
    echo "</table>"; // Fermeture du tableau
} else {
    echo "Aucune commande trouvée";
}
?>