# I - Fonctionnement global du jeu :

## Début de partie

Au lancement de la partie, le `index.php` va faire appel au `controleurPrincipal.php`. Celui-ci va vérifier si un code à
deviner existe déjà (signifiant qu'un jeu est en cours).
Si un jeu est déjà en cours, il ne fait rien. Sinon, il va créer une partie avec le statut `en cours` (pour plus de
détails, cf. `Partie II`) qu'il va enregistrer dans la variable de session `statutPartie`, générer un code qu'il va
enregistrer dans la variable de session `codeToGuess` à l'aide de la fonction `createCode()` du `controleurBot.php`,
initialiser le compteur d'essais à 0 et initialiser un tableau contenant les propositions que le joueur va proposer.

## Déroulé d'une partie

Le joueur va faire une proposition de 4 chiffres à l'aide des `<select>`, puis valider son choix. Le formulaire va
envoyer cette valeur au `controleurVerification.php` afin de comparer l'entrée de l'utilisateur avec le code secret (
pour plus de détails, cf. `Partie II`). À l'issue de cette vérification, l'entrée est enregistrée avec les différents
pions montrant les similitudes entre les 2 codes, afin d'être affichée sur le plateau. Le joueur peut alors rejouer à
nouveau, en s'aidant du résultat de son ancienne entrée

## Fin de partie

La partie peut se finir de 2 manières :

- Si le joueur a deviné le code en moins de 12 essais (https://www.regles-de-jeux.com/regle-du-mastermind/), le joueur a
  gagné. Un message apparaît pour lui annoncer sa victoire avec son nombre de tentatives, et il peut rejouer une
  nouvelle partie.
- Si le joueur n'est pas parvenu à deviner le code en 12 essais, un message lui annonce sa défaite, avec le code caché.
  Il peut alors rejouer une nouvelle partie.

Dans ces 2 cas, le bouton "Rejouer" fera appel au `controleurReset.php`, qui supprimera toutes les données contenues en
session (le code, le nombre d'essais, le statut de la partie et les anciennes propositions)

# II - Partie technique :

Vous trouverez ici des détails sur la partie technique, du fonctionnement des différents algorithmes aux choix
arbitraires réalisés afin de produire cette solution.

## Génération de la clé

Comme on peut le voir dans le `controleurBot.php`, la génération de cette clé est assez simple. Celle-ci est un String
de 4 caractères (les 4 chiffres à deviner). Ces 4 chiffres sont générés aléatoirement via la méthode `random_int()` de
PHP. Cette fonction pouvant renvoyer une RandomException, on l'entoure d'un try/catch afin de récupérer l'erreur en cas
de problème.

## Comparaison de la clé et de l'entrée utilisateur

Lorsque le joueur envoie sa réponse, celle-ci va passer dans le `controleurVerification.php`, et plusieurs processus se
passent :

1. Incrémentation du nombre d'essais : Le joueur ayant joué, on augmente son nombre d'essais
2. On récupère le code secret dans la variable `$codeToGuess`, et la réponse du joueur dans la variable `$proposition`
3. On va cloner cette dernière. Comme des traitements vont être faits sur la variable `$proposition`, mais qu'on a
   besoin de la valeur initiale pour l'afficher ensuite sur le plateau, on la clone.
4. On initialise un tableau vide `$points`. Celui-ci contiendra les valeurs qui permettront ensuite l'affichage des
   points dans la partie `Résultats` du tableau.
5. On passe dans une 1re boucle. Celle-ci a pour but de repérer tous les chiffres bien placés. Ainsi, on va avancer dans
   les 2 String `$proposition` et `$codeToGuess` et comparer leurs valeurs. Toutes les valeurs qui coïncident, afin
   d'éviter qu'elles soient relues, sont remplacées par les valeurs `7` dans `$proposition` et `8` dans `$codeToGuess`.
   Celles-ci étant hors de notre limite de 1 à 6, elles ne seront pas comptabilisées à nouveau. Enfin, on ajoute `1`
   dans le tableau. Celui-ci permettra d'ajouter un point blanc sur le plateau par la suite
6. On passe dans 2 nouvelles boucles. Cette fois-ci, celles-ci ont pour but de repérer tous les chiffres justes mais mal
   placés. Ainsi, pour chaque chiffre de `$codeToGuess`, on va parcourir tous les chiffres de `$proposition` et vérifier
   leur similitude. Le fait d'avoir modifié au préalable les valeurs déjà trouvées dans la 1re boucle évite de recompter
   des valeurs déjà comptées précedemment. Pour chaque chiffres égaux, on va ajouter un `2` dans le tableau `$points`.
   Celui-ci permettra ensuite d'afficher un point rouge sur le plateau. Enfin, on va remplacer la valeur
   de `$proposition` par un `9`, et celle de `$codeToGuess` par un 8. Ce `9` aurait pu être un 7, mais m'a permis lors
   du 1er débug de l'algorithme de comprendre quelle partie modifiait la variable `$proposition`. Comme elle n'influe en
   rien la partie, et facilite le débogage, je n'ai pas modifié cette valeur.
7. On évite les 2 conditions `if` car elles n'influent pas sur la comparaison. On en parlera en détails plus tard.
8. Ensuite, on enregistre dans la variable `$propositionToAdd` le String `$propositionToRecord` (contenant la valeur
   INITIALE entrée par le joueur), ainsi que le tableau `$points`.
9. Enfin, on enregistre `$propositionToAdd` dans la session PHP, afin de pouvoir afficher la nouvelle proposition et son
   résultat sur le plateau

## Passer du tableau au plateau

Dans cette partie, on va voir comment passer de la valeur formatée dans `$propositionToAdd` comme
suit : [String, Array], à un plateau de jeu.
Tout fonctionne grâce à un tableau `<table>` qui va être généré dans le `$vuePropositions.php`.
Dans l'ordre, celui-ci va :

1. Générer le `<th>`, l'entête du tableau
2. Vérifier si le `$_SESSION["propositions"]` existe (celui-ci est rempli puis actualisé à chaque comparaison entre une
   entrée utilisateur et la clé (cf. partie précédente)). Si oui, une 1re variable `$propositions` va récupérer son
   contenu.
3. Parcourir la variable `$propositions`
4. Pour chaque indice de la variable `$propositions`, créer une nouvelle ligne dans le tableau :
    1. On va parcourir le 1er objet (le String) avec une nouvelle boucle (pour rappel, voici la structure
       de `$propositions` : [[String, Array], [String, Array], ...]) contenant la valeur rentrée par le joueur. Pour
       chaque caractère, on va créer une nouvelle cellule dans le tableau qu'on va remplir avec celui-ci.
    2. On va ensuite parcourir le 2nd objet (l'Array), s'il n'est pas vide, avec une nouvelle boucle, et en fonction de
       la valeur à chaque indice, on va rajouter un point blanc ou rouge (1 = blanc | 2 = rouge). Ces valeurs ont été
       déterminées avant, dans l'algorithme de comparaison (cf. partie précédente).
5. Ajouter une ligne au tableau avec le texte `À vous de jouer !`
6. Générer une nouvelle ligne qui contiendra les `<select>` et le bouton de validation. Cette partie fonctionne comme
   suit :
    1. On initialise une variable `$display` qui contiendra le HTML généré.
    2. On a 3 conditions `if`, qui vont vérifier le statut de la partie (cf. `Choix personnels et clarifications`)
        1. Si la partie est en cours, on va générer 4 `<select>`, avec 4 noms différents afin de pouvoir facilement
           récupérer leurs valeurs dans le `controleurVerification.php`, avec des `<option>` allant de 1 à 6.
        2. Si la partie est gagnée, on va afficher un message de victoire, avec le nombre d'essais dont le joueur a eu
           besoin. On ajoute également un bouton pour Rejouer.
        3. Si la partie est perdue, on va afficher un message de défaite, avec le code secret. On ajoute également un
           bouton pour Rejouer
           À noter que dans ces 2 cas, le bouton Rejouer va appeler le `controleurReset.php` dont j'ai déjà détaillé l'
           utilité.

Ce plateau va enfin être appelé par le `index.php`, là où nous redirige le `controleurVerifcation.php`

## Choix personnels et clarifications

J'ai dû faire certains choix qu'il est nécessaire d'expliquer afin de comprendre pleinement le programme. Cette partie
ayant pour but de centraliser tous les choix que j'ai fais, il est possible que certains points aient déjà été détaillés
avant :

### Enregistrement des valeurs nécessaires à la partie

Dès le départ, et tout au long de la partie, on a besoin de certaines données nécessaires à son bon déroulement.
Celles-ci sont toutes contenues dans la session PHP. Voici où trouver les différentes valeurs :

- `$_SESSION["statutPartie"]`: int = Statut de la partie. Celui-ci peut avoir 3
  valeurs =  [0 => En cours, 1 => Gagnée, 2 => Perdue]. Ces valeurs sont arbitraires et peuvent être changées à votre
  guise pourvu que vous adaptiez tout ce qui en découle.
- `$_SESSION["codeToGuess"]` : string = Code à deviner. Celui-ci est généré par la fonction `createCode()`
  du `controleurBot.php`.
- `$_SESSION["nbEssais"]` : int = Nombre d'essais du joueur sur la partie en cours. Celui-ci est normalement contenu
  entre 0 (début de partie) et 12 (fin de partie)
- `$_SESSION["propositions"]` : array = Toutes les propositions du joueur sur la partie en cours.

Ces noms ont été pensés pour être intuitifs, afin que les données soient plus facilement accessibles.

### Pions rouges et blancs

Dans le `controleurVerification.php`, on voit que les pions blancs ont la valeur 1, et les pions rouges la valeur 2.
Tout comme le `$_SESSION["statutPartie"]`, celles-ci sont des valeurs arbitraires. Pourvu que vous changiez également
tout ce qui en découle, elles peuvent aussi être changées à votre guise.

### Ressources externes

Ce Mastermind utilise pour seul code externe le CSS stocké dans le fichier HTML exemple. Tout le reste est de ma
production.
Ce projet a été réalisé en 6h30

### Axes d'améliorations

Ce Mastermind n'inclut aucun élément de POO. En commençant le projet, je ne voyais pas comment en inclure, et j'ai donc
fonctionné principalement avec des Arrays afin de conserver mes valeurs.
Néanmoins, en y ayant reréfléchi vers la fin du projet, l'Array complexe `$propositionToAdd`
du `controleurVerification.php`, structuré comme suit = [String, Array], aurait pu être remplacé par une classe avec
cette structure = {proposition: String, points: Array}. En accédant à ces valeurs par des Getters/Setters, on aurait un
code plus lisible et des données mieux structurées.



 








