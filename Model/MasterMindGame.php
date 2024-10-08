<?php
use Random\RandomException;

class Model_MasterMindGame implements Model_AbstractGame
{
    private Model_StatutPartie $gameStatus;
    private string $codeToGuess = "";
    private array $data;

    public function __construct()
    {
    }

    /**
     * @param $boardSize
     * @return void
     */
    public function initGame($boardSize): void
    {
        if($this->codeToGuess === ""){
            $this->gameStatus = Model_StatutPartie::EnCours;
            $this->codeToGuess= $this->createCode();
            $this->data = [];
        }
    }

    /**
     * @return void
     */
    public function playMove(): void
    {
        $proposition = "";
        for ($i = 0; $i < 4; $i++) {
            $proposition .= $_POST["input" . $i];
        }
        $this->data[] = $proposition;
    }

    /**
     * Checks if $move is equal to the code. Returns true if both are equals, an array otherwise
     * @param $move
     * @return bool|array
     */
    public function checkWin($move): bool | array
    {
        if($move === $this->codeToGuess){
            return true;
        }
        else if(count($this->data) === 12){
            return false;
        }
        $points = [];
        $codeToGuess = $this->codeToGuess;
        //1er parcours - Recherche des pions blancs
        for ($i = 0; $i < 4; $i++) {
            if ($move[$i] === $codeToGuess[$i]) {
                $points[] = 'W';
                //On modifie les valeurs dans le $codeToGuess et $proposition pour éviter qu'elles soient recomptées
                $move[$i] = 7;
                $codeToGuess[$i] = 8;
            }
        }
        //2nd parcours - Recherche des pions rouges
        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 4; $j++) {
                if ($codeToGuess[$i] === $move[$j]) {
                    $points[] = "R";
                    //On modifie les valeurs dans le $codeToGuess et $move pour éviter qu'elles soient recomptées
                    $move[$j] = 9;
                    $codeToGuess[$i] = 8;
                }
            }
        }
        return $points;
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

    public function getGameStatus(): Model_StatutPartie
    {
        return $this->gameStatus;
    }

    public function setGameStatus(Model_StatutPartie $gameStatus): void
    {
        $this->gameStatus = $gameStatus;
    }

    public function getCodeToGuess(): string
    {
        return $this->codeToGuess;
    }

    public function setCodeToGuess(string $codeToGuess): void
    {
        $this->codeToGuess = $codeToGuess;
    }

    public function serialize(): array
    {
        return ["status" => $this->gameStatus->value, "codeToGuess" => $this->codeToGuess, "data" => $this->data];
    }

    public static function unserialize(array $data): Model_MasterMindGame{
        $MasterMind = new Model_MastermindGame();
        $MasterMind->setGameStatus(Model_StatutPartie::from($data["status"]));
        $MasterMind->setCodeToGuess($data["codeToGuess"]);
        $MasterMind->setData($data["data"]);
        return $MasterMind;
    }
}