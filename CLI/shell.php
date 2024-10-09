<?php


if(php_sapi_name() !== "cli") {
    exit;
}
require_once "autoLoader.php";
require_once "autoLoaderCLI.php";

$main = new App_Main();
$main->initGame();