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
    $isChecked = false;
    for($j = 0; $j < 4; $j++){
        if($codeToGuess[$i] === $proposition[$j] && $isChecked === false){
            $isChecked = true;
            if($i === $j){
                $points[] = 1;
                $proposition[$j] = 7;
            }
            else{
                $points[] = 2;
                $proposition[$j] = 7;
            }
        }
    }
}
if($points === [1, 1, 1, 1]){
    //Faire la win
}
else if($_SESSION["nbEssais"] === 12){
    //Faire la lose
}
$propositionToAdd = [$propositionToRecord, $points];
$_SESSION["propositions"][] = $propositionToAdd;


header("Location: ../index.php");
exit();