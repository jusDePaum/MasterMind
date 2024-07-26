<?php
session_start();
$_SESSION['nbEssais']++;

$proposition = "";
$codeToGuess = $_SESSION["codeToGuess"];
for ($i = 0; $i < 4; $i++) {
    $proposition .= $_POST["input".$i];
}
$propositionToRecord = $proposition;
$points = [];
for($i = 0; $i < 4; $i++){
    if($proposition[$i] === $codeToGuess[$i]){
        $points[] = 1;
        $proposition[$i] = 7;
        $codeToGuess[$i] = 8;
    }
}
for($i = 0; $i < 4; $i++){
    for($j = 0; $j < 4; $j++){
        if($codeToGuess[$i] === $proposition[$j]){
            $points[] = 2;
            $proposition[$j] = 9;
            $codeToGuess[$i] = 8;
        }
    }
}
if($points === [1, 1, 1, 1]){
    $_SESSION["statutPartie"] = 1;
}
else if($_SESSION["nbEssais"] === 12){
    $_SESSION["statutPartie"] = 2;
}
$propositionToAdd = [$propositionToRecord, $points];
$_SESSION["propositions"][] = $propositionToAdd;


header("Location: ../index.php");
exit();