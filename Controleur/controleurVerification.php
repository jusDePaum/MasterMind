<?php
require_once "../autoLoader.php";
session_start();

$MasterMind = Model_MasterMindGame::unserialize($_SESSION['MasterMindGame']);
$MasterMind->playMove();
$_SESSION["MasterMindGame"] = $MasterMind->serialize();

//Redirection vers index.php
header("Location: ../index.php");
exit();