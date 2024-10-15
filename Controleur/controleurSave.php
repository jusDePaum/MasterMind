<?php
require_once '../autoLoader.php';
session_start();

$MasterMind = Model_MasterMindGame::unserialize($_SESSION['MasterMindGame']);
if(isset($_POST["save"])){
    $repository = new Repository_JSONFileRepository();
    $toSave = $repository->save($MasterMind);
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=WeemindGame.weemind');
    echo $toSave;
}