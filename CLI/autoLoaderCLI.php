<?php

function autoLoaderCLI($class): void
{
    if(str_starts_with($class, "App_")){
        $class = substr($class, strlen("App_"));
        include_once "App/$class.php";
    }
}

spl_autoload_register("autoLoaderCLI");