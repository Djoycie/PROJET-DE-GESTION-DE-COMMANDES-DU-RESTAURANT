<?php
require_once 'database.php';

if (isset($_POST["nom"]) && isset($_POST["telephone"]) && isset($_POST["adresse"])) {
  $nom = $_POST["nom"];
  $telephone = $_POST["telephone"];
  $adresse = $_POST["adresse"];

  $sql = "INSERT INTO commande (nom, telephone, adresse, prix_total) VALUES ('$nom', '$telephone', '$adresse', '" . $_SESSION["prix_total"] . "')";
  $conn->query($sql);

  foreach ($_SESSION["panier"] as $article) {
    $sql = "INSERT INTO commande_article (id_commande, id_article, quantite, prix) VALUES (LAST_INSERT_ID(), '" . $article["id"] . "', '" . $article["quantite"] . "', '" . $article["prix"] . "')";
    $conn->query($sql);
  }

  unset($_SESSION["panier"]);
  unset($_SESSION["prix_total"]);

  header("Location: index.php");
  exit;
}
?>
