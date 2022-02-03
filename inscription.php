<?php
session_start();


if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['pseudo']) && !empty($_POST['pseudo']) && isset($_POST['pass']) && !empty($_POST['pass'])) {
    // Ici le formulaire est complet
    // On récupère les valeurs des champs
    $pseudo = strip_tags($_POST['pseudo']);
    $email = strip_tags($_POST['email']);

    // On récupère le mot de passe et on le chiffre
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // On se connecte à la base
    include 'utils/bdd.php';

    // On écrit la requête
    $sql = 'INSERT INTO `users`(`email`, `password`, `pseudo`) VALUES (?,?,?);';

    // On prépare la requête
    $query = $bdd->prepare($sql);

    // On exécute la requête
    $query->execute($_POST['pseudo'], $_POST['email'], $_POST['password']);

    // On redirige vers la page d'accueil
    header('Location: index.php');
} else {
    echo 'Tous les champs sont obligatoires';
}

include 'partials/header.php';
?>
<div class="col-12 my-1">
    <h1>Inscription</h1>
    <form method="post">
        <div class="form-group">
            <label for="email">E-mail :</label>
            <input class="form-control" type="email" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="pseudo">Pseudo :</label>
            <input class="form-control" type="text" id="pseudo" name="pseudo">
        </div>
        <div class="form-group">
            <label for="pass">Mot de passe :</label>
            <input class="form-control" type="password" id="password" name="password">
        </div>
        <button class=" btn btn-primary">M'inscrire</button>
    </form>
</div>
<?php
include 'partials/footer.php';
