
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

// Traitement de la recherche

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f7f7f7;
        }
        h1 {
            color: white;
            font-size: 36px;
            margin-bottom: 20px;
            
        }
        h2 {
            color: #666;
            font-size: 24px;
            margin-bottom: 10px;
            text-align:center;
           
        }
        h1::first-letter{
            color:orange;
            font-size: 80px;
        }
        ul {

            list-style-type: none;
            padding: 0;
            margin: 0;
            display:flex;
            flex-wrap:wrap;
        }
        li {
            transition: transform 0.3s, box-shadow 0.3s; /* Transition pour l'effet de survol */
            padding: 20px;
            border-bottom: 1px solid #ddd;
            border-radius: 10px;
            margin:13px;
            width: 28%; /* Deux colonnes avec un peu d'espace */
    box-shadow: 0 2px 5px rgba(14, 13, 13, 0.1);
    border:1px solid orange;
        }
        li:hover {
    transform: translateY(-5px); /* Effet de levée au survol */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Ombre plus prononcée au survol */
}

        form {
            margin-top: 20px;
        }
        label {
            display:inline block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="number"] {
            width: 25%;
            height: 10px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin:10px;
        }
        .panier {
            background-color: #f2f2f2;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .onglets {
            display: flex;
            justify-content: space-between;
            margin-bottom: 100px;
            margin-left: 800px;
            margin-top:-75px;
            
        }
        .onglet {
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            color:white;
        }

        .onglet:hover {
            background-color: orange;
            color:black;
        }
        .contenu-onglet {
            display: none;
        }
        .contenu-onglet.actif {
            display: block;
            border-bottom:2px solid orange;
        }
        #recherche{
        width: 150px;
        height: 10px;
        
       }

       #entete {
        position: relative;
    overflow: hidden; /* Cache le débordement */
    white-space: nowrap; /* Empêche le texte de se plier */
    width: 100%;
}

#entete h1 {
    display: inline-block; /* Permet l'animation en ligne */
    animation: defilement 8s linear infinite; /* Animation sur 10 secondes, linéaire et répétée à l'infini */
    padding-right: 100%;
}

@keyframes defilement {
    0% {
        transform: translateX(0); /* Commence à l'extérieur à gauche */
    }
    100% {
        transform: translateX(100%); /* Finit à l'extérieur à droite */
    }
}
       
    header{
       background-image:url('imgs/pageheader-banner.jpg');
       background-size:cover;
       height: 400px;
       width: 100%;
    }  
    img{
        width: 100%; /* Prend toute la largeur du cadre */
        height: auto; /* Garde le ratio d'aspect de l'image */
    } 

    #commande {
       background-color:orange;
      
}

#supp {
       background-color:red;
       
}

   </style> 
    
</head>
    
<body>
   
    <header>
        <h1>Master Chef</h1>
    
    <main>
        <section class="onglets">
            <div class="onglet" id="onglet-menu">Menu</div>
            <div class="onglet" id="onglet-a-propos">À propos de nous</div>
            <div class="onglet" id="onglet-contacts">Temoignages</div>
            <div class="onglet" id="onglet-panier">Panier</div>
           
        </section>
    
    <div id="entete">
        <h1>Que des menus delicieux donc venez savourez vos papilles.</h1>
    </div>
    </header>
    
    <section class="contenu-onglet actif" id="contenu-menu">
    <h2>Menu</h2>
    <div class="form-container">
        <form action="" method="post" class="form-recherche">
            <label for="recherche">Rechercher un menu :</label>
            <input type="text" id="recherche" name="recherche">
            <input type="submit" value="Rechercher">

        </form>
        <form action="" method="post" class="form-filtre">
            <label for="categorie">Filtrer par catégorie :</label>
            <select id="categorie" name="categorie">
                <option value="">Toutes les catégories</option>
<?php 
$sql = "SELECT DISTINCT categorie FROM menus";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
    echo "<option value='" . $row["categorie"] . "'>" . $row["categorie"] . "</option>";
}
?>
</select>

<input class="filt" type="submit" value="Filtrer">
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['recherche'])) {
    $recherche = $_POST['recherche'];
    $sql = "SELECT * FROM menus WHERE nom LIKE '%$recherche%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<h2>Résultats de la recherche</h2>";
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li>";
            echo "<h2>" . $row["nom"] . "</h2>";
            echo "<p>" . $row["description"] . "</p>";
            echo "<p>Prix: XAF " . $row["prix"] . "</p>";
            echo "<img src='" . $row["image"] . "'>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucun résultat trouvé";
    }
}
?>
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['categorie'])) {
$categorie = $_POST['categorie'];
$sql = "SELECT * FROM menus WHERE categorie = '$categorie'";
} else {
$sql = "SELECT * FROM menus";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
echo "<ul>";
while($row = $result->fetch_assoc()) {
echo "<li>";
echo "<h2>" . $row["nom"] . "</h2>";
echo "<p> Description: " . $row["description"] . "</p>";
echo "<p>Prix: XAF " . $row["prix"] . "</p>";
echo "<p>Categorie: " . $row["categorie"] . "</p>";
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
?>
</section>
<section class="contenu-onglet" id="contenu-a-propos">
<h2>À propos de nous</h2>
<p>Master Chef est un restaurant typique qui fait dans toute sortes de repas varié.</p>
<p>Notre menu est diversifié en plusieurs categories on note les plats de resistance,les desserts, les entrees ,et les boissons.</p>
<p>Nous avons ainsi un site web de gestion mais aussi un restaurant physique.</p>
<p>Notre restaurant physique est situe a yaounde plus precisement au quartier mendong.</p>
<p>Nous avons un systeme de livraison pour les commandes donc tout pour vous faire plaisir .</p>
<p>Nous faisons aussi dans le service traiteur pour toute sorte d'evenements.</p>
</section>

<section class="contenu-onglet" id="contenu-contacts">
  <h2>Témoignages</h2>
  <button id="envoyer-temoignage"  style="display: none;">Envoyer votre témoignage</button>
  <form id="formulaire-temoignage" action="ajouter_temoin.php" method ="post "style="display: none;">
    <label for="temoignage">Votre témoignage :</label>
    <textarea id="temoignage" name="temoignage" required></textarea>
    <input type="submit" name="envoyer" value="Envoyer">
  </form>
  <?php
    // Afficher les témoignages
    $sql = "SELECT * FROM temoignage";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo "<p>" . $row["temoignage"] . "</p>";
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='id_temoignage' value='" . $row["id"] . "'>";
       echo "</form>";
      }
    }
  ?>
</section>


<section class="contenu-onglet" id="contenu-panier">
<h2>Panier</h2>
<?php 
if (isset($_SESSION["panier"]) && count($_SESSION["panier"]) > 0) {
echo "<ul>";
foreach ($_SESSION["panier"] as $key => $article) {
echo "<li>";
echo "<h2>" . $article["nom"] . "</h2>";
echo "<p>Catégorie: " . $article["categorie"] . "</p>";
echo "<p>Quantité: " . $article["quantite"] . "</p>";
echo "<p>Prix calculé: " . $article["prix"] . "</p>";
echo "<form action='' method='post'>";
echo "<input type='hidden' name='id_article' value='" . $key . "'>";
echo "<input id='supp' type='submit' name='supprimer' value='Supprimer'>";
echo "</form>";
echo "</li>";
}
echo "</ul>";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['supprimer'])) {
$id_article = $_POST['id_article'];
if (isset($_SESSION["panier"][$id_article])) {
    unset($_SESSION["panier"][$id_article]);
    $_SESSION["prix_total"] = 0;
    foreach ($_SESSION["panier"] as $article) {
        $sql = "SELECT prix FROM menus WHERE id = '" . $article["id"] . "'";
        $result = $conn->query($sql);
        $prix_article = $result->fetch_assoc()["prix"];
        $quantite_article = $article["quantite"];
        $_SESSION["prix_total"] += $prix_article * $quantite_article;
    }
}
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                }
                echo "<p>Montant total: " . $_SESSION["prix_total"] . "</p>";
                echo "<form action='commande.php' method='post'>";
                echo "<input id='commande' type='submit' value='Commander'>";
                echo "</form>";
            } else {
                echo "<h2>Le panier est vide.</h2>";
            }
            ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Restaurant Master Chef</p>
    </footer>
    <script>
        const onglets = document.querySelectorAll('.onglet');
        const contenus = document.querySelectorAll('.contenu-onglet');
        
        onglets.forEach((onglet, index) => {
            onglet.addEventListener('click', () => {
                contenus.forEach((contenu) => {
                    contenu.classList.remove('actif');
                });
                contenus[index].classList.add('actif');
            });
        });

        const ongletTemoignages = document.getElementById('onglet-contacts');
const boutonEnvoyer = document.getElementById('envoyer-temoignage');
const formulaire = document.getElementById('formulaire-temoignage');

ongletTemoignages.addEventListener('click', () => {
  boutonEnvoyer.style.display = 'block';
});

boutonEnvoyer.addEventListener('click', () => {
  formulaire.style.display = 'block';
  boutonEnvoyer.style.display = 'none';
});


    </script>
</body>
</html>

