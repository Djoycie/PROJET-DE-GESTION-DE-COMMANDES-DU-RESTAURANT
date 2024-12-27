<?php
session_start(); // Démarrer la session
require_once 'database.php'; // Inclure le fichier de connexion à la base de données

// Vérifier si le formulaire a été soumis
if (isset($_POST["id_article"]) && isset($_POST["quantite"])) {
  $id_article = $_POST["id_article"];
  $quantite = $_POST["quantite"];

  // Récupérer l'article depuis la base de données
  $sql = "SELECT * FROM menu WHERE id = '$id_article'";
  $result = $conn->query($sql);
  $article = $result->fetch_assoc();

  if (isset($_SESSION["panier"])) {
    $panier = $_SESSION["panier"];
    // Ajouter l'article au panier
    $panier[] = array(
      "id" => $article["id"],
      "nom" => $article["nom"],
      "quantite" => $quantite,
      "prix" => $article["prix"] * $quantite
    );
    $_SESSION["panier"] = $panier;
    $_SESSION["prix_total"] += $article["prix"] * $quantite;
  } else {
    // Créer un nouveau panier
    $_SESSION["panier"] = array(
      array(
        "id" => $article["id"],
        "nom" => $article["nom"],
        "quantite" => $quantite,
        "prix" => $article["prix"] * $quantite
      )
    );
    $_SESSION["prix_total"] = $article["prix"] * $quantite;
}

echo "<p>Article ajouté au panier avec succès!</p>";
}

header("Refresh: 1; URL=index.php");
exit();

//Récupérer tous les articles pour le formulaire
$sql = "SELECT * FROM menu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ajouter au Panier</title>
</head>
<body>
<h1>Menu</h1>
<form action="ajouter_au_panier.php" method="post">
  <label for="id_article">Choisissez un article :</label>
  <select name="id_article" id="id_article" required>
    <?php while ($article = $result->fetch_assoc()): ?>
      <option value="<?= $article['id']; ?>">
        <?= htmlspecialchars($article['nom']) . " - Prix: " . htmlspecialchars($article['prix']) . "€"; ?>
      </option>
    <?php endwhile; ?>
  </select>
  <label for="quantite">Quantité :</label>
  <input type="number" name="quantite" id="quantite" min="1" value="1" required>
  <button type="submit">Ajouter au Panier</button>
</form>
 <!-- Afficher le panier -->
 