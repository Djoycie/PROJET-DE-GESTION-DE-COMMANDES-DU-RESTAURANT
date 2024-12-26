<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ajout d'un élément au menu
if (isset($_POST['ajouter'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $image_url = $_POST['image_url'];

    $sql = "INSERT INTO menu (nom, description, prix) VALUES ('$nom', '$description', '$prix')";
    $conn->query($sql);

    $menu_id = $conn->insert_id;
    $sql = "INSERT INTO images (menu_id, image_url) VALUES ('$menu_id', '$image_url')";
    $conn->query($sql);
}

?>
