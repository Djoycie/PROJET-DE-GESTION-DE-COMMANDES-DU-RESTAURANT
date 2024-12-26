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
$email = $_POST['email']; // Changer ici pour récupérer l'email
$mdp = $_POST['mdp'];

// Préparation et exécution de la requête
$sql = "SELECT mdp FROM customer WHERE email = ?"; // Changer ici pour utiliser l'email
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

// Vérification si l'utilisateur existe
if ($stmt->num_rows > 0) {
    $stmt->bind_result($mdp_hash);
    $stmt->fetch();
    
    // Vérification du mot de passe
    if (password_verify($mdp, $mdp_hash)) {
        // Authentification réussie
        echo "Connexion réussie !";
        // Rediriger vers une page protégée ou la page d'accueil
        header("Location: index.html");
        exit();
    } else {
        echo "Mot de passe incorrect.";
    }
} else {
    echo "Aucun utilisateur trouvé avec cet email.";
}

$stmt->close();
$conn->close();
?>