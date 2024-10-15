<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <title>Weemind</title>
    <style>
        @import url(Style/styles.css);
    </style>
</head>
<body>
<main>
    <div>
        <h1>MasterMind</h1>
        <h2>Règles du jeu :</h2>
        <p class="align-left">L'ordinateur choisit une combinaison à 4 chiffres entre 1 et 6.<br><br>
            Le joueur propose une combinaison. L'ordinateur lui retourne un code sous forme de pion sans préciser quel
            chiffre
            correspond à quel pion : un pion rouge par chiffre juste mais mal placé, et un pion blanc par chiffre bien
            placé.<br><br>
            Lorsque le code est 4 pions blancs, le joueur a gagné et peut relancer une partie.</p>
    </div>
    <div class="manageSave">
        <form method="post" action="/Controleur/controleurSave.php">
            <p>Tu peux sauvegarder ta partie et la reprendre plus tard via les boutons ci-dessous.<br>
                Utilise le champ ci-dessous pour nommer ton fichier/choisir le fichier à charger !</p>
            <input type="submit" name="save" value="Sauvegarder">
        </form>
        <form method="post" action="Controleur/controleurUpload.php" enctype="multipart/form-data">
            <input type="file" onchange="this.form.submit()" accept= "*.weemind" name="file">
        </form>
    </div>
    <form method="post" action="/Controleur/controleurVerification.php">
        <?php
        require_once "autoLoader.php";
        session_start();

        if(!isset($_SESSION['MasterMindGame'])){
            $MasterMind = new Model_MasterMindGame();
            $_SESSION['MasterMindGame'] = $MasterMind->serialize();
        }
        else{
            $MasterMind = $_SESSION['MasterMindGame'];
        }
        echo "<br>";
        echo "<br>";
        echo "<br>";

        require_once "Vue/vuePropositions.php"; //Appel de la vuePropositions pour le plateau de jeu
        ?>
    </form>
</main>
</body>
</html>