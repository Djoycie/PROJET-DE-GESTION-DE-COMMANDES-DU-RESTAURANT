<?php
session_start(); // Démarrer la session
require_once 'database.php'; // Inclure le fichier de connexion à la base de données

// Récupérer l'id de l'article à supprimer
$id_article = $_POST["id_article"];

// Supprimer l'article du panier

if (isset($_SESSION["panier"])) {
    $panier = $_SESSION["panier"];
    foreach ($panier as $key => $article) {
      if ($article["id"] == $id_article) {
        unset($panier[$key]);
        $_SESSION["panier"] = $panier;
        // Recalculer le prix total
        $prix_total = 0;
        foreach ($_SESSION["panier"] as $article) {
          $prix_total += $article["prix"];
        }
        $_SESSION["prix_total"] = $prix_total;
        break;
      }
    }
  }
  
  
//Rediriger vers la page index.php
header("Location: index.php");
exit;
?>
