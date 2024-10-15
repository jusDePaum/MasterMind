<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <title>Weemind</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">

    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <style>
        @import url(Style/styles.css);
    </style>
</head>
<body>
<main>
    <div>
        <h1>MasterMind</h1>
        <div class="navbar">
            <form action="Vue/vueConfigNouvellePartie.php">
                <button type="submit" class="btn btn-green"><i class="fa fa-gamepad" aria-hidden="true"></i></button>
            </form>
            <div class="manageSave">
                <form method="post" action="/Controleur/controleurSave.php">
                    <button type="submit" class="btn btn-yellow" name="save">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i>
                    </button>
                </form>
                <button class="btn btn-blue"><i class="fa fa-hdd-o" aria-hidden="true" onclick="document.getElementById('labelFile').click()"></i></button>
            </div>
        </div>
    </div>
    <h2>Règles du jeu :</h2>
    <p class="align-left">L'ordinateur choisit une combinaison à 4 chiffres entre 1 et 6.<br><br>
        Le joueur propose une combinaison. L'ordinateur lui retourne un code sous forme de pion sans préciser quel
        chiffre
        correspond à quel pion : un pion rouge par chiffre juste mais mal placé, et un pion blanc par chiffre bien
        placé.<br><br>
        Lorsque le code est 4 pions blancs, le joueur a gagné et peut relancer une partie.</p>
    <form method="post" action="/Controleur/controleurVerification.php">
        <?php
        require_once "autoLoader.php";
        session_start();

        if (!isset($_SESSION['MasterMindGame'])) {
            $MasterMind = new Model_MasterMindGame();
            $_SESSION['MasterMindGame'] = $MasterMind->serialize();
        } else {
            $MasterMind = Model_MasterMindGame::unserialize($_SESSION['MasterMindGame']);
        }
        echo "<br>";
        echo "<br>";
        echo "<br>";

        require_once "Vue/vuePropositions.php"; //Appel de la vuePropositions pour le plateau de jeu
        ?>
    </form>
    <form method="post" action="Controleur/controleurUpload.php" style="height: 0" enctype="multipart/form-data">
        <label for="file" id="labelFile"></label>
        <input type="file" style="height: 0" onchange="this.form.submit()" accept="*.weemind" id="file" name="file">
    </form>
</main>
</body>
</html>