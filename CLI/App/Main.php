<?php


use Random\RandomException;

class App_Main
{
    public Model_MasterMindGame $masterMindGame;

    public function initGame(): void
    {
        $this->masterMindGame = new Model_MasterMindGame();
        $this->displayRules();
        $this->essai();
    }

    public function essai(bool $erreur = false): void
    {
        try {
            if ($this->masterMindGame->getGameStatus() === Model_StatutPartie::EnCours) {
                (!$erreur) ? $this->makeBoard() / $reponse = readline("Propose une réponse (4 chiffres entre 1 et 6) : ") : $reponse = readline("Propose une réponse VALIDE (4 chiffres entre 1 et 6) : ");
                if (preg_match('/^[0-6]{4}$/', $reponse)) {
                    $this->playMove($reponse);
                } else {
                    $this->essai(true);
                }
            } else if ($this->masterMindGame->getGameStatus() === Model_StatutPartie::Victoire) {
                if (count($this->masterMindGame->getMoves()) === 1) {
                    echo "Bien joué ! Vous avez gagné en " . count($this->masterMindGame->getMoves()) . " coup ;) \n";
                } else {
                    echo "Bien joué ! Vous avez gagné en " . count($this->masterMindGame->getMoves()) . " coups ;) \n";
                }
                $this->replay();
            } else {
                echo "Dommage ! Le code secret était " . $this->masterMindGame->getConfig()[Model_MasterMindGame::CONFIG_CODE_TO_GUESS] . "\n";
                $this->replay();
            }
        } catch (TypeError $e) {
            $this->essai(true);
        }
    }

    public function playMove($reponse): void
    {
        if (count($this->masterMindGame->getMoves()) >= 12) {
            $this->masterMindGame->setGameStatus(Model_StatutPartie::Defaite);
        }
        if ($reponse === $this->masterMindGame->getConfig()[Model_MasterMindGame::CONFIG_CODE_TO_GUESS]) {
            $this->masterMindGame->setGameStatus(Model_StatutPartie::Victoire);
        }
        $moves = $this->masterMindGame->getMoves();
        $moves[] = $reponse;
        $this->masterMindGame->setMoves($moves);
        $this->essai();
    }

    public function makeBoard(): void
    {
        $reponses = $this->masterMindGame->getMoves();
        $balises = [];
        for ($i = 0; $i < count($reponses); $i++) {
            $balises[] = $this->masterMindGame->checkWin($reponses[$i]);
            echo $reponses[$i] . " - [" . implode("][", $balises[$i]) . "]\n";
        }
    }

    public function replay(): void
    {
        $replay = readline("Rejouer ? [O] / [N] : ");
        if ($replay !== "O") {
            exit();
        }
        system("clear");
        $this->initGame();
    }

    public function displayRules(): void
    {
        echo "
            MasterMind \n
            Règles du jeu : \n
            L'ordinateur choisit une combinaison à 4 chiffres entre 1 et 6.
            Le joueur propose une combinaison. L'ordinateur lui retourne un code sous forme de balises sans préciser quel
            chiffre correspond à quelle balise : une balise [R] par chiffre juste mais mal placé, et une balise [W] par chiffre bien
            placé
            Lorsque le code est 4 balises [W], le joueur a gagné et peut relancer une partie\n
            À toi de jouer !\n\n";
    }
}