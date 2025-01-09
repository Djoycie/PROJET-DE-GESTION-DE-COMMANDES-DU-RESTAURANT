<?php
require_once 'database.php'; // Assure-toi que ce fichier contient la connexion à la base de données

// Vérifier si une demande de suppression a été faite
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Récupérer l'ID du témoignage à supprimer

    // Préparer la requête pour éviter les injections SQL
    $stmt = $conn->prepare("DELETE FROM temoignage WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "<p>Témoignage supprimé avec succès.</p>";
    } else {
        echo "<p>Erreur : impossible de supprimer le témoignage.</p>";
    }
    header("Refresh: 1; URL=satisfaction.php");
  exit();

    // Fermer la déclaration
    $stmt->close();
}

// Récupérer tous les témoignages
$sql = "SELECT * FROM temoignage";
$result = $conn->query($sql);
echo "<style>
    body {
        background-image: radial-gradient(circle, #f9ecec, #fae8e4, #f6d7d2, hsl(64, 55%, 89%)); 
    }
</style>";


echo "<h1 style ='text-align:center;margin:20px;color:tomato; text-decoration:underline;'> Rapport satisfaction client</h1>";

if ($result->num_rows > 0) {
    echo "<table border='1' style='margin-top:50px;border-collapse: collapse;margin-left:200px;'>
            <tr style='background-color:white;'>
                <th>ID</th>
                <th>Témoignage</th>
                <th>Actions</th>
            </tr>";
    
    // Afficher chaque témoignage
    while ($row = $result->fetch_assoc()) {
        echo "<tr style='background-color:rgba(255,255,255,0.5);padding:5px;'>
                <td>" . $row['id'] . "</td>
                <td>" . htmlspecialchars($row['temoignage']) . "</td>
                <td>
                    <form action='' method='post' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer ce témoignage ?\");'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input style='background-color:#ff0000; color: white; padding: 8px 20px; border: none; border-radius: 5px; cursor: pointer; margin:15px;' type='submit' value='Supprimer'>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucun témoignage trouvé.</p>";
}

// Fermer la connexion
$conn->close();
?>