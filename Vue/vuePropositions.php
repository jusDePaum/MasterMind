<table>
    <tr>
        <th colspan="4">Propositions</th>
        <th>Résultat</th>
    </tr>
    <?php
    require_once 'autoLoader.php';
    session_start();

    if(isset($_SESSION["MasterMindGame"])){
        $MasterMind = Model_MasterMindGame::unserialize($_SESSION['MasterMindGame']);
        $propositions = $MasterMind->getData();
        for($i = 0; $i < count($propositions); $i++){
            echo "<tr>";
            for($j = 0; $j < 4; $j++) {
                echo "<td>" . $propositions[$i][$j] . "</td>";
            }
            $pions = $MasterMind->checkWin($propositions[$i]);
            if(gettype($pions) === "array"){
                if(!empty($pions)){
                    echo "<td>";
                    for ($j = 0; $j < count($pions); $j++) {
                        if ($pions[$j] === "W") {
                            echo "<span class=\"pion blanc\">•</span>";
                        }
                        if ($pions[$j] === "R") {
                            echo "<span class=\"pion rouge\">•</span>";
                        }
                    }
                    echo "</td>";
                }
            }
            else if($pions) {
                $MasterMind->setGameStatus(Model_StatutPartie::Victoire);
                echo "<td>";
                for ($i = 0; $i < 4; $i++) {
                    echo "<span class=\"pion blanc\">•</span>";
                }
                echo "</td>";
                $_SESSION["MasterMindGame"] = $MasterMind->serialize();
            }
            else{
                $MasterMind->setGameStatus(Model_StatutPartie::Defaite);
                $_SESSION["MasterMindGame"] = $MasterMind->serialize();
            }
        }
    }
    ?>
    <tr>
        <td colspan="5">À vous de jouer !</td>
    </tr>
    <tr>
        <td colspan="5">
            <?php
            require_once 'autoLoader.php';
            $display = "";
            if(isset($_SESSION["MasterMindGame"])) {
                $MasterMind = Model_MasterMindGame::unserialize($_SESSION['MasterMindGame']);
                if ($MasterMind->getGameStatus() === Model_StatutPartie::EnCours) { // Si la partie est en cours
                    // Ajout de 4 <select> avec 6 <option> (de 1 à 6)
                    for ($i = 0; $i < 4; $i++) {
                        $display .= "<select name=\"input$i\">";
                        for ($j = 1; $j <= 6; $j++) {
                            $display .= "<option value=\"{$j}\">{$j}</option>";
                        }
                        $display .= "</select>";
                    }
                    // Ajout du bouton submit
                    $display .= "<input type=\"submit\" value=\"Valider\" id=\"submitAnswer\">";
                    echo $display;
                }
                if ($MasterMind->getGameStatus() === Model_StatutPartie::Victoire) { // Si la partie est gagnée
                    $display = "<div><b>Bien joué !</b> Vous avez gagné en " . count($MasterMind->getData()) . " essais ! <a href='Controleur/controleurReset.php'>Rejouer</a>"; //Affichage du texte de victoire
                    echo $display;
                }
                if ($MasterMind->getGameStatus() === Model_StatutPartie::Defaite) { // Si la partie est perdue
                    $display = "<div><b>Dommage !</b> Le code secret était " . $MasterMind->getCodeToGuess() ." ! <a href='Controleur/controleurReset.php'>Rejouer</a>"; //Affichage du texte de défaite
                    echo $display;
                }
            }
            ?>
        </td>
    </tr>
</table>