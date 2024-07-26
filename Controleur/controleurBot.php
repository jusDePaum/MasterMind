<?php

use Random\RandomException;

/***
 * Create the code the player has to break
 */
function createCode(): string
{
    try {
        $codeMaker = strval(random_int(1, 6)); //Initialisation de la variable codeMaker, avec le 1er chiffre, qui contiendra temporairement la clé
        for ($i = 0; $i < 3; $i++) {
            $codeMaker .= random_int(1, 6); //Ajout des 3 chiffres suivants à la clé
        }
        return $codeMaker;
    } catch (RandomException $e) { //Erreur provenant de la fonction random_int()
        return $e->getMessage();
    }
}