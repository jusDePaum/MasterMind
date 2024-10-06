<?php

namespace Model;

use Random\RandomException;
require_once 'AbstractGame.php';
class MasterMindGame implements AbstractGame
{

    private array $data;
    private static array $instances = [];

    private function __construct()
    {
    }

    public static function getInstance(): MasterMindGame{
        $subclass = MasterMindGame::class;
        if(!isset(self::$instances[$subclass])){
            self::$instances[$subclass] = new MasterMindGame();
        }
        return self::$instances[$subclass];
    }

    /**
     * @param $boardSize
     * @return void
     */
    public function initGame($boardSize): void
    {
        if (!isset($_SESSION["codeToGuess"])) {
            $_SESSION["statutPartie"] = 0; //cf. README - Choix personnels et clarifications
            $_SESSION["codeToGuess"] = $this->createCode(); //Code que le joueur doit deviner
            $_SESSION["nbEssais"] = 0; //Nombre d'essais réalisés
            $_SESSION["propositions"] = []; //Tableau contenant les différentes propositions du joueur
        }
    }

    /**
     * @param $move
     * @return void
     */
    public function playMove($move): void
    {
        //Called after a move, check win conditions by calling checkWin() function, then records the $move in $data
    }

    /**
     * @param $move
     * @return bool
     */
    public function checkWin($move): bool
    {
        //Checks if $move is equal to the code, and save the similarities in $data. Returns true if both are equals
        return false;
    }


    /***
     * Creates the code the player has to break
     * @return string
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
            return "1111";
        }
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return void
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}