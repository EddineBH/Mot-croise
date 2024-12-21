<?php session_start();
include("config.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css" />

<title>Contenu de la Base de Données</title>
<style>
 
</style>

</style>
</head>
<body>

<nav id='nav'>
<ul>
    <?php 
        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Erreur de connexion à la base de données: " . $conn->connect_error);
        }

        $conn->select_db($database);

        $mail = $_SESSION['adressemail'];
        
        $sql = "SELECT * FROM utilisateurs WHERE email = '$mail'";
        $result_identity = $conn->query($sql);
        if($result_identity->num_rows >0){
            //la personne actuellement connectée est un medecin
            $nom = $_SESSION['nom'];
            $display = 1;
            $id = $_SESSION['id'];
            ?>
 <?php
            echo "<li>Dr. $nom</li>"; 
        } else {
            $display= 2;
            //la personne actuellement connectée est l'admin
            // echo "<li>Vous êtes connecté en tant qu'administrateur</li>"; 
        }
    ?>
    <br><br>
    <li><a href="deconnection.php"><img src="door-open-fill.svg" width="40" height="50"></a></li>
    <li><a href="#" onclick="toggleBlur('popup_ajout_patient')"><img src="person-add.svg" width="50" height="40"></a></li>
    <li><a href="bdd.php"><img src="house.svg" width="50" height="40"></a></li>
    <li><a href="#" onclick="toggleBlur('popup_preference')"><img src="gear.svg" width="50" height="40"></a></li>
</ul>
</nav>
<div id="blur" class="blur"></div>
<div id="popup_ajout_patient" class="popup">
<div class="popup-content">
    <!-- <h2>Ajouter un nouveau patient</h2>
    <form action="traitement_formulaire.php" method="POST">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" placeholder="Nom" required><br><br>
        
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" placeholder="Prénom" required><br><br>
        
        <label for="date_naissance">Date de naissance:</label>
        <input type="date" id="date_naissance" name="date_naissance" required><br><br>
        
        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" placeholder="Adresse"><br><br>
        
        <label for="numero_tel">Numéro de téléphone:</label>
        <input type="text" id="numero_tel" name="numero_tel" placeholder="Numéro de téléphone"><br><br>
        <br><br>
        
        <button type="submit">Ajouter</button>
        <button type="button" onclick="closePopup('popup_ajout_patient')">Fermer</button>
    </form> -->
</div>
</div>

<div id="popup_preference" class="popup">
<div class="popup-content">
    <!-- <h2>Modifier les paramètres du médecin</h2>
    <form action="traitement_formulaire_settings.php" method="POST">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" placeholder="Nom" required><br><br>
        
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" placeholder="Prénom" required><br><br>
        
        <label for="date_naissance">Date de naissance:</label>
        <input type="date" id="date_naissance" name="date_naissance" required><br><br>
        
        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" placeholder="Adresse"><br><br>
        
        <label for="numero_tel">Numéro de téléphone:</label>
        <input type="text" id="numero_tel" name="numero_tel" placeholder="Numéro de téléphone"><br><br>
        <br><br>
        
        <button type="submit">Modifier</button>
        <button type="button" onclick="closePopup('popup_preference')">Fermer</button>
    </form> -->
</div>
</div>
<div id="popup_traitement" class="popup">
<div class="popup-content">
   
</div>
</div>

<?php
if (empty($_GET)) {
?>
<h1 style="color: #000;">Listes des tableaux existants</h1>
<div>
<?php
if($display != 1 ){
    $sql = "SELECT * FROM mots_croises";
    $resultat = $conn->query($sql);

    // Vérifiez d'abord si la requête a retourné des résultats
    // if ($resultat->num_rows > 0) {
        
    //     // Récupérer la matrice en JSON depuis la base de données
    //     $row = $resultat->fetch_assoc();
    //     $matrice_json = $row['lettres'];
    // // echo "<pre>" . htmlspecialchars($matrice_json) .
    //     // Décoder la matrice JSON en tableau PHP
    //     $matrice = json_decode($matrice_json, true);
    
    //     // Vérifier si le décodage a réussi
    //     if ($matrice === null) {
    //         // Afficher une erreur si le JSON est invalide
    //         echo "Erreur de décodage JSON. La matrice est peut-être mal formée.";
    //     } else {
    //         // Afficher la matrice sous forme de tableau HTML
    //         echo "<table border='1' style='border-collapse: collapse; text-align: center;'>"; // Début du tableau
    
    //         foreach ($matrice as $ligne) {
    //             echo "<tr>"; // Début de la ligne
    //             foreach ($ligne as $lettre) {
    //                 echo "<td style='padding: 10px;'>" . htmlspecialchars($lettre) . "</td>"; // Afficher chaque lettre dans une cellule de tableau
    //             }
    //             echo "</tr>"; // Fin de la ligne
    //         }
    //         echo "</table>"; // Fin du tableau
    //     }
    // } else {
    //     echo "Aucun mot croisé trouvé.";
    // }
    
    

    if ($resultat->num_rows > 0) {
        echo '<table id="tableau">';
        echo '<tr>';
        while ($fieldinfo = $resultat->fetch_field()) {
            if($fieldinfo->name != 'id'  ){
            echo '<th>' . $fieldinfo->name . '</th>';
            }
        }
        echo '</tr>';
        while ($row = $resultat->fetch_assoc()) {
            echo '<tr>';
            foreach ($row as $key => $value) {
                echo '<td onclick="test()">' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p style="color: red;">Aucun tableau existe.</p>';
    }
} else {
    echo'dine';

}

} else {
// $nompren = $_GET['nompren'];
$id = $_GET['id'];
echo($id);
    
// $db = mysqli_connect("localhost", "new_user","password", "myPodDB");

$sql = "SELECT * FROM mots_croises where id = 'id'";
$resultat = $conn->query($sql);

// Vérifiez d'abord si la requête a retourné des résultats
if ($resultat->num_rows > 0) {
    
    // Récupérer la matrice en JSON depuis la base de données
    $row = $resultat->fetch_assoc();
    $matrice_json = $row['lettres'];
// echo "<pre>" . htmlspecialchars($matrice_json) .
    // Décoder la matrice JSON en tableau PHP
    $matrice = json_decode($matrice_json, true);

    // Vérifier si le décodage a réussi
    if ($matrice === null) {
        // Afficher une erreur si le JSON est invalide
        echo "Erreur de décodage JSON. La matrice est peut-être mal formée.";
    } else {
        // Afficher la matrice sous forme de tableau HTML
        echo "<table border='1' style='border-collapse: collapse; text-align: center;'>"; // Début du tableau

        foreach ($matrice as $ligne) {
            echo "<tr>"; // Début de la ligne
            foreach ($ligne as $lettre) {
                echo "<td style='padding: 10px;'>" . htmlspecialchars($lettre) . "</td>"; // Afficher chaque lettre dans une cellule de tableau
            }
            echo "</tr>"; // Fin de la ligne
        }
        echo "</table>"; // Fin du tableau
    }
} else {
    echo "Aucun mot croisé trouvé.";
}

?>
<button onclick="toggleBlur('popup_traitement')" style=""> Ajouter un schema basal </button>
<?php
}


?>
<script>
function test(){
    var tableau = document.getElementById('tableau');
    var lignes = tableau.getElementsByTagName('tr');

    for (var i = 1; i < lignes.length; i++) {
        lignes[i].addEventListener('click', function() {
            // Récupérer les données de la ligne cliquée
            var cells = this.getElementsByTagName('td');
            var id = cells[0].innerText;
            var taille = cells[1].innerText;
            var lettre = cells[2].innerText;
            var date = cells[3].innerText;
            var niveau = cells[4].innerText;
            // Rediriger vers une nouvelle page en passant les données en tant que paramètres de l'URL
            window.location.href = 'bdd.php?id=' + encodeURIComponent(id);
        });
    }
}
function toggleBlur(idPopup) {
    var blur = document.getElementById("blur");
    var popup = document.getElementById(idPopup);

    if (blur.style.visibility === "hidden") {
        blur.classList.add("blur");
        blur.style.visibility = "visible";
        blur.style.display = "block";
        popup.style.display = "block";
    } else {
        blur.classList.remove("blur");
        blur.style.visibility = "hidden";
        blur.style.display = "none";
        popup.style.display = "none";
    }
}

function closePopup(idPopup) {
    var blur = document.getElementById("blur");
    var popup = document.getElementById(idPopup);

    blur.classList.remove("blur");
    blur.style.visibility = "hidden";
    blur.style.display = "none";
    popup.style.display = "none";
}


</script>

<?php
$conn->close();
?>
</body>
</html>