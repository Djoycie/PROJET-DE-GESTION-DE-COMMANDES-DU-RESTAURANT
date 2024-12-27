<?php
// Initialiser la session
session_start();

// Définir les variables de session
if (!isset($_SESSION["panier"])) {
  $_SESSION["panier"] = array();
}

if (!isset($_SESSION["prix_total"])) {
  $_SESSION["prix_total"] = 0;
}

require_once 'database.php';

// Afficher les articles du menu
$sql = "SELECT * FROM menu";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<h1>Menu</h1>";
  echo "<ul>";
  while($row = $result->fetch_assoc()) {
    echo "<li>";
    echo "<h2>" . $row["nom"] . "</h2>";
    echo "<p>" . $row["description"] . "</p>";
    echo "<p>Prix: " . $row["prix"] . "</p>";
    echo "<img src='" . $row["image"] . "'>";
    echo "<form action='ajouter_au_panier.php' method='post'>";
    echo "<input type='hidden' name='id_article' value='" . $row["id"] . "'>";
    echo "<label for='quantite'>Quantité:</label>";
    echo "<input type='number' id='quantite' name='quantite' value='1' min='1'>";
    echo "<input type='submit' value='Ajouter au panier'>";
    
    echo "</form>";
    echo "</li>";
  }
  echo "</ul>";
} else {
  echo "Aucun article trouvé";
}

// Afficher le panier
if (isset($_SESSION["panier"]) && count($_SESSION["panier"]) > 0) {
  echo "<h2>Panier</h2>";
  echo "<ul>";
  
  foreach ($_SESSION["panier"] as $key => $article) {
    echo "<li>";
    echo "<h2>" . $article["nom"] . "</h2>";
    echo "<p>Quantité: " . $article["quantite"] . "</p>";
    echo "<p>Prix calculé: " . $article["prix"] . "</p>";

    // Formulaire pour supprimer l'article du panier
    echo "<form action='' method='post'>";
    echo "<input type='hidden' name='id_article' value='" . $key . "'>"; // Utiliser l'index comme identifiant
    echo "<input type='submit' name='supprimer' value='Supprimer'>";
    echo "</form>";

    echo "</li>";
  }
  
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['supprimer'])) {
    // Retirer l'article du panier
    $id_article = $_POST['id_article'];
  
    // Vérifier si l'article existe dans le panier
    if (isset($_SESSION["panier"][$id_article])) {
      // Supprimer l'article
      unset($_SESSION["panier"][$id_article]);
  
      // Recalculer le prix total
      $_SESSION["prix_total"] = 0;
  
      // Réinitialiser le prix total
      // Parcourir le panier pour recalculer le montant total
      foreach ($_SESSION["panier"] as $article) {
        // Récupérer le prix initial de l'article dans la base de données
        $sql = "SELECT prix FROM menu WHERE id = '" . $article["id"] . "'";
        $result = $conn->query($sql);
        $prix_article = $result->fetch_assoc()["prix"];
  
        // Calculer le prix total pour cet article
        $quantite_article = $article["quantite"];
        $_SESSION["prix_total"] += $prix_article * $quantite_article;
      }
    }
  
    // Rediriger pour éviter la double soumission de formulaire
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  }
  
  

  echo "</ul>";
  echo "<p>Montant total: " . $_SESSION["prix_total"] . "</p>";
} else {
  echo "<h2>Le panier est vide.</h2>";
}
?>