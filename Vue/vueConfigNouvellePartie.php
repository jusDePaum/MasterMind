<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <title>Weemind</title>
    <style>
        @import url(../Style/styles.css);
    </style>
</head>
<body>
<main>
    <h1>MasterMind</h1>
    <button onclick="history.back()">Retour</button>
    <form method="post" action="../Controleur/controleurNouvellePartie.php">
        <label>
            Nombre de colonnes
            <input type="number" name="nbCol" min="3" max="8" value="4" required>
        </label>
        <button type="submit">Nouvelle partie !</button>
    </form>
</main>
</body>
</html>