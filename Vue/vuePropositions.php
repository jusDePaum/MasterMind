<table>
    <tr>
        <th>Propositions</th>
        <th>Résultat</th>
    </tr>
    <?php
    if (isset($_SESSION["propositions"])) {
        $propositions = $_SESSION["propositions"];
        for ($i = 0; $i < count($propositions); $i++) {
            echo "<tr>";
            for ($j = 0; $j < 4; $j++) {
                echo "<td>" . $propositions[$i][0][$j] . "</td>";
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
        <td>À vous de jouer !</td>
    </tr>
    <tr>
        <td>
            <?php
            $selects = "";
            for ($i = 0; $i < 4; $i++) {
                $selects .= "<select name=\"input$i\">";
                for ($j = 1; $j <= 6; $j++) {
                    $selects .= "<option value=\"{$j}\">{$j}</option>";
                }
                $selects .= "</select>";
            }
            echo $selects;
            ?>
            <input type="submit" value="Valider" id="submitAnswer">
        </td>
    </tr>
</table>