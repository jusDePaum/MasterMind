<?php
require_once '../autoLoader.php';
session_start();


$MasterMind = Model_MasterMindGame::unserialize($_SESSION["MasterMindGame"]);
if(isset($_POST["save"])){
    if(isset($_POST["filename"]) && $_POST["filename"] !== ""){
        $MasterMind->save($_POST["filename"]);
    }
    else{
        $MasterMind->save();
    }
    header('Location: ../index.php');
    exit();
}
if(isset($_POST["load"])){
    if(isset($_POST["filename"]) && $_POST["filename"] !== ""){
        $MasterMind->load($_POST["filename"]);
    }
    else{
        $MasterMind->load();
    }
    $_SESSION["MasterMindGame"] = $MasterMind->serialize();
    header('Location: ../index.php');
    exit();
}