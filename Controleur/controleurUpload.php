<?php
require_once "../autoLoader.php";
session_start();

$repo = new Repository_JSONFileRepository();
$datas = $repo->load($_FILES['file']['tmp_name']);

$MM = new Model_MasterMindGame();
$MM->fromSaveArray($datas);
$_SESSION["MasterMindGame"] = $MM->serialize();

header("Location: ../index.php");
exit();