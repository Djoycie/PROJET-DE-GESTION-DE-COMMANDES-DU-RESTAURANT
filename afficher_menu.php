<?php
require_once 'database.php';

// Vérifie si une demande de suppression a été faite
if (isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $delete_sql = "DELETE FROM menu WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
}

// Récupère les articles du menu
$sql = "SELECT * FROM menu";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Menu</h1>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>";
        echo "<h2>" . htmlspecialchars($row["nom"]) . "</h2>";
        echo "<p>" . htmlspecialchars($row["description"]) . "</p>";
        echo "<p>Prix: " . htmlspecialchars($row["prix"]) . " fcfa</p>";
        echo "<img src='" . htmlspecialchars($row["image"]) . "' alt='" . htmlspecialchars($row["nom"]) . "' style=''width:100px;height:auto;'>";
        
        // Bouton pour supprimer
        echo "<form method='post' style='display:inline;'>";
        echo "<input type='hidden' name='delete_id' value='" . htmlspecialchars($row["id"]) . "'>";
        echo "<button type='submit' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet article ?\");'>Supprimer</button>";
        echo "</form>";
        
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Aucun article trouvé";
}
?>
