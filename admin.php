<?php
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nom = $_POST["nom"];
  $description = $_POST["description"];
  $image = $_FILES["image"];
  $prix = $_POST["prix"];
  $categorie = $_POST["categorie"]; // Nouvelle variable pour la catégorie

  // Créer un répertoire pour stocker les images
  $repertoire_images = 'images/';
  if (!file_exists($repertoire_images)) {
    mkdir($repertoire_images, 0777, true);
  }

  // Stocker l'image dans le répertoire
  $nom_image = $repertoire_images . basename($image["name"]);
  move_uploaded_file($image["tmp_name"], $nom_image);

  // Insérer les données dans la base de données avec la nouvelle colonne catégorie
  $sql = "INSERT INTO menus (nom, description, image, prix, categorie) VALUES ('$nom', '$description', '$nom_image', '$prix', '$categorie')";
  
  if ($conn->query($sql) === TRUE) {
    echo "Menu ajouté avec succès!";
    header("Refresh: 0; URL=afficher_menu.php");
    exit();
  } else {
    echo "Erreur lors de l'ajout de l'article: " . $sql . " " . $conn->error;
  }
}
?>