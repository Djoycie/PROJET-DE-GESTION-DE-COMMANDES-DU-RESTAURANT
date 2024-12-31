<?php
require_once 'database.php';

// Vérifie si une demande de suppression a été faite
if (isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $delete_sql = "DELETE FROM menus WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
}

// Récupère les articles du menu
$category_filter = isset($_POST['category_filter']) ? $_POST['category_filter'] : '';
$search_name = isset($_POST['search_name']) ? $_POST['search_name'] : '';

if (!empty($search_name)) {
    $sql = "SELECT * FROM menus WHERE nom LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search_name . "%";
    $stmt->bind_param("s", $search_param);
} elseif (!empty($category_filter)) {
    $sql = "SELECT * FROM menus WHERE categorie = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category_filter);
} else {
    $sql = "SELECT * FROM menus";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h1 style='text-align:center'>GESTION DU MENU</h1>";
    echo "<form method='post'>";
    echo " <input type='text' name='search_name' placeholder='Rechercher un menu'>";
    echo " <button type='submit' style='background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;'>Rechercher</button>";
    echo "</form>";
    echo "<form method='post'>";
    echo " <select name='category_filter'>";
    echo " <option value=''>Toutes les catégories</option>";
    echo " <option value='Boissons'" . ($category_filter == 'Boissons' ? ' selected' : '') . ">Boissons</option>";
    echo " <option value='plat de resistance'" . ($category_filter == 'plat de resistance' ? ' selected' : '') . ">plat de resistance</option>";
    echo " <option value='Desserts'" . ($category_filter == 'Desserts' ? ' selected' : '') . ">Desserts</option>";
    echo " <option value='Entree'" . ($category_filter == 'Entree' ? ' selected' : '') . ">Entree</option>";
    // Ajoute d'autres catégories selon tes besoins
    echo " </select>";
    echo " <button type='submit' style='background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;'>Filtrer</button>";
    echo "</form>";
    echo "<table border='1' style='width:100%; border-collapse: collapse; '>";
    echo " <tr>";
    echo " <th style='padding:5px;'>Nom</th>";
    echo " <th>Description</th>";
    echo " <th>Prix (fcfa)</th>";
    echo " <th>Catégorie</th>";
    echo " <th>Image</th>";
    echo " <th>Actions</th>";
    echo " </tr>";
    while ($row = $result->fetch_assoc()) {
        echo " <tr  style='padding:5px;'>";
        echo " <td  style='padding:5px;'>" . htmlspecialchars($row["nom"]) . "</td>";
        echo " <td  style='padding:5px;'>" . htmlspecialchars($row["description"]) . "</td>";
        echo " <td  style='padding:5px;'>" . htmlspecialchars($row["prix"]) . "</td>";
        echo " <td  style='padding:5px;'>" . htmlspecialchars($row["categorie"]) . "</td>";
        echo " <td  style='padding:5px;'><img src='" . htmlspecialchars($row["image"]) . "' alt='" . htmlspecialchars($row["nom"]) . "' style='width:100px;height:auto;'></td>";
        // Colonne pour les boutons Modifier, Supprimer et Ajouter
        echo " <td  style='margin:5px;'>";
        echo " <form method='post' action='admin.html' style='display:inline;'>";
        echo " <button type='submit' style='background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin:1px;'>Ajouter</button>";
        echo " </form>";
        echo " <form method='post' action='modify_article.php' style='display:inline;'>";
        echo " <input type='hidden' name='article[id]' value='" . $row['id'] . "'>";
        echo " <input type='hidden' name='article[nom]' value='" . $row['nom'] . "'>";
        echo " <input type='hidden' name='article[description]' value='" . $row['description'] . "'>";
        echo " <input type='hidden' name='article[prix]' value='" . $row['prix'] . "'>";
        echo " <input type='hidden' name='article[categorie]' value='" . $row['categorie'] . "'>";
        echo " <input type='hidden' name='article[image]' value='" . $row['image'] . "'>";
        echo " <button type='submit' style='background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;'>Modifier</button>";
        echo " </form>";
        echo " <form method='post' style='display:inline;'>";
        echo " <input type='hidden' name='delete_id' value='" . htmlspecialchars($row["id"]) . "'>";
        echo " <button type='submit' style='background-color: #ff0000; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-right:-86px;' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet article ?\");'>Supprimer</button>";
        echo " </form>";
        echo " </td>";



        // Fin de la colonne Actions
        echo " </tr>";
        // Fin de la ligne
    }
    echo "</table>";
    // Fin du tableau
} else {
    echo "Aucun article trouvé";
}

$stmt->close();
$conn->close();
?>

