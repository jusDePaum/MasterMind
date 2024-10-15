<?php

function autoLoader($class): void
{
    if(str_starts_with($class, "Model_")){
        $class = substr($class, strlen("Model_"));
        include_once "Model/$class.php";
    }
    else if(str_starts_with($class, "Repository_")){
        $class = substr($class, strlen("Repository_"));
        include_once "Repository/$class.php";
    }
}

spl_autoload_register("autoLoader");