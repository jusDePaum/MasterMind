<?php

function autoLoader($class): void
{
    if(str_starts_with($class, "Model_")){
        $class = substr($class, strlen("Model_"));
        include_once "Model/$class.php";
    }
}

spl_autoload_register("autoLoader");