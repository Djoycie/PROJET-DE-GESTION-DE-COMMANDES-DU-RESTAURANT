
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
            echo "<p>Prix: " . $row["prix"] . "</p>";
            echo "<img src='" . $row["image"] . "'>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucun résultat trouvé";
    }
}
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
        }
        h1::first-letter{
            color:orange;
            font-size: 80px;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        li {
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="number"] {
            width: 15%;
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

    #contenu-a-propos{
      
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
echo "<p>" . $row["description"] . "</p>";
echo "<p>Prix: " . $row["prix"] . "</p>";
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
<h2>Temoignages</h2>
<p>Moi c'est Ndock Mbidi grand restaurateur je confirme la qualité des plats de Master Chef.</p>
<p>Accompagné de Ndock Mbidi moi c'est Tresor Mula j'ai fait un tour au restaurant Master Chef et a vrai dire les gars c'est une dinguerie.</p>
<p>Trop parler c'est maladie allez s'y faire un tour.</p>
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
echo "<input type='submit' name='supprimer' value='Supprimer'>";
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
                echo "<input type='submit' value='Commander'>";
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
    </script>
</body>
</html>

