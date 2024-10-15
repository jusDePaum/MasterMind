<?php
require_once "../autoLoader.php";

session_start();
session_destroy();
session_start();
if(isset($_POST["nbCol"])){
    $nbCol = $_POST["nbCol"];
    $masterMindGame = new Model_MasterMindGame((int)$nbCol);
    $_SESSION["MasterMindGame"] = $masterMindGame->serialize();
}

header("Location:../index.php");
exit();