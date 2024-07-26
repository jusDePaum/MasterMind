<table>
    <tr>
        <th colspan="4">Propositions</th>
        <th>Résultat</th>
    </tr>
    <?php
    if (isset($_SESSION["propositions"])) {
        $propositions = $_SESSION["propositions"];
        for ($i = 0; $i < count($propositions); $i++) {
            echo "<tr>";
            for ($j = 0; $j < 4; $j++) {
                echo "<td>".$propositions[$i][0][$j].'</td>';
            }
            if (!empty($propositions[$i][1])) {
                echo "<td>";
                for ($j = 0; $j < count($propositions[$i][1]); $j++) {
                    if ($propositions[$i][1][$j] === 1) {
                        echo "<span class=\"pion blanc\">•</span>";
                    }
                    if ($propositions[$i][1][$j] === 2) {
                        echo "<span class=\"pion rouge\">•</span>";
                    }
                }
                echo "</td>";
            }
            echo "</tr>";
        }
    }
    ?>
    <tr>
        <td colspan="5">À vous de jouer !</td>
    </tr>
    <tr>
        <td colspan="5">
            <?php
            $display = "";
            if ($_SESSION["statutPartie"] === 0) { // Si la partie est en cours
                for ($i = 0; $i < 4; $i++) {
                    $display .= "<select name=\"input$i\">";
                    for ($j = 1; $j <= 6; $j++) {
                        $display .= "<option value=\"{$j}\">{$j}</option>";
                    }
                    $display .= "</select>";
                }
                $display .= "<input type=\"submit\" value=\"Valider\" id=\"submitAnswer\">";
                echo $display;
            }
            if ($_SESSION["statutPartie"] === 1) { // Si la partie est gagnée
                $display = "<div><b>Bien joué !</b> Vous avez gagné en ".$_SESSION["nbEssais"]." essais ! <a href='Controleur/controleurReset.php'>Rejouer</a>";
                echo $display;
            }
            if($_SESSION["statutPartie"] === 2){ // Si la partie est perdue
                $display = "<div><b>Dommage !</b> Le code secret était ".$_SESSION["codeToGuess"]." ! <a href='Controleur/controleurReset.php'>Rejouer</a>";
                echo $display;
            }
            ?>
        </td>
    </tr>
</table>