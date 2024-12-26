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

// Récupération des données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$mdp = $_POST['mdp'];
$adresse = $_POST['adresse'];
$telephone = $_POST['telephone'];

// Hashage du mot de passe
$mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

// Insertion des données dans la base de données
$sql = "INSERT INTO customer (nom, prenom, email, mdp, adresse, telephone) VALUES ('$nom', '$prenom', '$email', '$mdp_hash', '$adresse', '$telephone')";

if ($conn->query($sql) === TRUE) {
echo "Inscription réussie !";
header ("Location:index.html");
exit();
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>