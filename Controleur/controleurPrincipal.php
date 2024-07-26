<?php
require_once "Controleur/controleurBot.php";

if (!isset($_SESSION["codeToGuess"])) {
    $_SESSION["statutPartie"] = 0;
    $_SESSION["codeToGuess"] = createCode(); //Code que le joueur doit deviner
    $_SESSION["nbEssais"] = 0; //Nombre d'essais réalisés
    $_SESSION["propositions"] = []; //Tableau contenant les différentes propositions du joueur
}