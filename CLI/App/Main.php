<?php


use Random\RandomException;

class App_Main
{
    private Model_StatutPartie $gameStatus;
    private string $codeToGuess;
    private array $data;

    public function initGame(): void
    {
        $this->displayRules();
        $this->codeToGuess = $this->createCode(4);
        $this->gameStatus = Model_StatutPartie::EnCours;
        $this->data = [];
        $this->essai();
    }

    public function essai(bool $erreur = false): void
    {
        if($this->gameStatus === Model_StatutPartie::EnCours){
            (!$erreur) ? $this->makeBoard() / $reponse = readline("Propose une réponse (4 chiffres entre 1 et 6) : ") : $reponse = readline("Propose une réponse VALIDE (4 chiffres entre 1 et 6) : ");
            if(preg_match('/^[0-6]{4}$/', $reponse)){
                $this->playMove($reponse);
            }
            else{
                $this->essai(true);
            }
        }
        else if($this->gameStatus === Model_StatutPartie::Victoire) {
            if (count($this->data) === 1) {
                echo "Bien joué ! Vous avez gagné en " . count($this->data) . " coup ;) \n";
            } else {
                echo "Bien joué ! Vous avez gagné en " . count($this->data) . " coups ;) \n";
            }
            $replay = readline("Rejouer ? [0] / [N] : ");
            if($replay !== "O"){
                exit();
            }
            system("clear");
            $this->initGame();
        }
        else {
            echo "Dommage ! Le code secret était " . $this->codeToGuess . "\n";
            $replay = readline("Rejouer ? [0] / [N] : ");
            if($replay !== "O"){
                exit();
            }
            system("clear");
            $this->initGame();
        }

    }

    public function playMove($reponse): void
    {
        $this->data[] = $reponse;
        if(count($this->data) >= 12){
            $this->gameStatus = Model_StatutPartie::Defaite;
        }
        if($reponse === $this->codeToGuess){
            $this->gameStatus = Model_StatutPartie::Victoire;
        }
        $this->essai();
    }

    public function makeBoard(): void
    {
        $reponses = $this->data;
        $balises = [];
        for($i = 0; $i < count($reponses); $i++){
            $balises[] = $this->checkWin($reponses[$i]);
            echo $reponses[$i] . " - " . $balises[$i] . "\n";
        }
    }

    public function checkWin($move): string
    {
            $points = "";
            $codeToGuess = $this->codeToGuess;
            //1er parcours - Recherche des pions blancs
            for ($i = 0; $i < 4; $i++) {
                if ($move[$i] === $codeToGuess[$i]) {
                    $points .= '[W]';
                    //On modifie les valeurs dans le $codeToGuess et $proposition pour éviter qu'elles soient recomptées
                    $move[$i] = 7;
                    $codeToGuess[$i] = 8;
                }
            }
            //2nd parcours - Recherche des pions rouges
            for ($i = 0; $i < 4; $i++) {
                for ($j = 0; $j < 4; $j++) {
                    if ($codeToGuess[$i] === $move[$j]) {
                        $points .= "[R]";
                        //On modifie les valeurs dans le $codeToGuess et $move pour éviter qu'elles soient recomptées
                        $move[$j] = 9;
                        $codeToGuess[$i] = 8;
                    }
                }
            }
            return $points;
    }







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

    public function displayRules(): void
    {
        echo "
            MasterMind \n
            Règles du jeu : \n
            L'ordinateur choisit une combinaison à 4 chiffres entre 1 et 6.
            Le joueur propose une combinaison. L'ordinateur lui retourne un code sous forme de balises sans préciser quel
            chiffre correspond à quelle balise : une balise [R] par chiffre juste mais mal placé, et une balise [W] par chiffre bien
            placé
            Lorsque le code est 4 balies [W], le joueur a gagné et peut relancer une partie\n
            À toi de jouer !\n\n";
    }
}