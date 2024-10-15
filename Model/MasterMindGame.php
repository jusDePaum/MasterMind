<?php

use Random\RandomException;

class Model_MasterMindGame extends Model_AbstractGame
{
    const CONFIG_CODE_TO_GUESS = "codeToGuess";

    public function __construct(int $boardSize = 4)
    {
        parent::initGame($boardSize, 1, [self::CONFIG_CODE_TO_GUESS => $this->createCode($boardSize)]);
    }

    /**
     * @param string|null $move
     * @return void
     */
    public function playMove(?string $move = ""): void
    {
        $proposition = "";
        for ($i = 0; $i < $this->config[$this::CONFIG_BOARD_SIZE]; $i++) {
            $proposition .= $_POST["input" . $i];
        }
        $this->moves[] = $proposition;
    }

    /**
     * Checks if $move is equal to the code. Returns true if both are equals, an array otherwise
     * @param $move
     * @return array|null
     */
    public function checkWin($move): array|bool
    {
        $codeToGuess = $this->config[$this::CONFIG_CODE_TO_GUESS];
        if ($move === $codeToGuess) {
            return true;
        }
        $points = [];
        //1er parcours - Recherche des pions blancs
        for ($i = 0; $i < $this->config[$this::CONFIG_BOARD_SIZE]; $i++) {
            if ($move[$i] === $codeToGuess[$i]) {
                $points[] = 'W';
                //On modifie les valeurs dans le $codeToGuess et $proposition pour éviter qu'elles soient recomptées
                $move[$i] = 7;
                $codeToGuess[$i] = 8;
            }
        }
        //2nd parcours - Recherche des pions rouges
        for ($i = 0; $i < $this->config[$this::CONFIG_BOARD_SIZE]; $i++) {
            for ($j = 0; $j < $this->config[$this::CONFIG_BOARD_SIZE]; $j++) {
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
     * @param int $boardSize
     * @return string
     */
    function createCode(int $boardSize): string
    {
        try {
            $codeMaker = strval(random_int(1, 6)); //Initialisation de la variable codeMaker, avec le 1er chiffre, qui contiendra temporairement la clé
            for ($i = 0; $i < $boardSize-1; $i++) {
                $codeMaker .= random_int(1, 6); //Ajout des x chiffres suivants à la clé
            }
            return $codeMaker;
        } catch (RandomException) { //Erreur provenant de la fonction random_int()
            return "1111";
        }
    }

    public function toSaveArray(): array
    {
        return [
            static::SAVE_GAME_STATUS => $this->gameStatus,
            static::SAVE_MOVES => $this->moves,
            static::SAVE_CONFIG => $this->config
        ];
    }

    public function fromSaveArray(array $data): void
    {
        $this->gameStatus = Model_StatutPartie::from($data[static::SAVE_GAME_STATUS]);
        $this->moves = $data[static::SAVE_MOVES];
        $this->config = $data[static::SAVE_CONFIG];
    }
}