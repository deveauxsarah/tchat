<?php
// On active l'accès à la session
session_start();

if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
    // On récupère les valeurs saisies
    $mail = strip_tags($_POST['email']);
    $pass = $_POST['password'];

    // On vérifie si l'email existe dans la base de données
    // On se connecte à la base
    include 'utils/bdd.php';

    // On écrit la requête
    $sql = 'SELECT * FROM `users` WHERE `email` = :email;';

    // On prépare la requête
    $query = $bdd->prepare($sql);

    // On exécute la requête
    $query->execute();

    // On récupère les données
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Soit on a une réponse dans $user, soit non
    // On vérifie si on a une réponse
    if (!$user) {
        echo 'Email et/ou mot de passe invalide';
    } else {
        // On vérifie que le mot de passe saisi correspond à celui en base
        // password_verify($passEnClairSaisi, $passBaseDeDonnees)
        if (password_verify($password, $user['password'])) {
            // On crée la session "user"
            // On ne stocke JAMAIS de données dont on ne maîtrise pas le contenu
            $_SESSION['user'] = [
                'id'    => $user['id'],
                'email' => $user['email'],
                'pseudo'  => $user['pseudo']
            ];

            header('Location: index.php');
        } else {
            echo 'Email et/ou mot de passe invalide';
        }
    }
} else {
    echo "Veuillez remplir tous les champs...";
}


include './partials/header.php';
?>
<div class="col-12 my-1">
    <h1>Connexion</h1>
    <form method="post">
        <div class="form-group">
            <label for="email">E-mail :</label>
            <input class="form-control" type="email" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input class="form-control" type="password" id="password" name="password">
        </div>
        <button class="btn btn-primary">Me connecter</button>
    </form>
</div>
<?php
include './partials/footer.php';
