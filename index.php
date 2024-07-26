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
<div>
    <h1>MasterMind</h1>
    <h2>Règles du jeu :</h2>
    <p>L'ordinateur choisit une combinaison à 4 chiffres entre 1 et 6.<br><br>
        Le joueur propose une combinaison. L'ordinateur lui retourne un code sous forme de pion sans préciser quel chiffre
        correspond à quel pion : un pion rouge par chiffre juste mais mal placé, et un pion blanc par chiffre bien
        placé.<br><br>
        Lorsque le code est 4 pions blancs, le joueur a gagné et peut relancer une partie.</p>
</div>
<form method="post" action="/Controleur/controleurVerification.php">
<?php
session_start();
require_once 'Controleur/controleurPrincipal.php';
require_once "Vue/vuePropositions.php";
?>
</form>
</body>
</html>

