<?php
session_start();
//Incrémentation du nombre d'essais du joueur
$_SESSION['nbEssais']++;

//Récupération du code secret
$codeToGuess = $_SESSION["codeToGuess"];

//Récupération du code rentré par le joueur
$proposition = "";
for ($i = 0; $i < 4; $i++) {
    $proposition .= $_POST["input".$i];
}

//Duplication du code rentré par le joueur (cf README Partie II)
$propositionToRecord = $proposition;
//Initialisation du tableau pour compter les points (qui donneront les pions blancs et rouge)
$points = [];

//1er parcours - Recherche des pions blancs
for($i = 0; $i < 4; $i++){
    if($proposition[$i] === $codeToGuess[$i]){
        $points[] = 1; //Donnera les pions blancs
        //On modifie les valeurs dans le $codeToGuess et $proposition pour éviter qu'elles soient recomptées
        $proposition[$i] = 7;
        $codeToGuess[$i] = 8;
    }
}

//2nd parcours - Recherche des pions rouges
for($i = 0; $i < 4; $i++){
    for($j = 0; $j < 4; $j++){
        if($codeToGuess[$i] === $proposition[$j]){
            $points[] = 2; //Donnera les pions rouges
            //On modifie les valeurs dans le $codeToGuess et $proposition pour éviter qu'elles soient recomptées
            $proposition[$j] = 9;
            $codeToGuess[$i] = 8;
        }
    }
}
//Si 4 pions blancs
if($points === [1, 1, 1, 1]){
    $_SESSION["statutPartie"] = 1; //Alors victoire
}
//Si 12 essais
else if($_SESSION["nbEssais"] === 12){
    $_SESSION["statutPartie"] = 2; //Alors défaite
}
//Enregistrement du couple "Proposition, points"
$propositionToAdd = [$propositionToRecord, $points];

//Enregistrement dans la session
$_SESSION["propositions"][] = $propositionToAdd;

//Redirection vers index.php
header("Location: ../index.php");
exit();