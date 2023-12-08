<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/page-connexion-inscription.css">
    <title>Inscription - Book Your Medias</title>
</head>

<body>
    <nav>
        <a href="#"><img src="./assets/images/page-presentation-media/logo-book-your-medias.png" alt="logo du site" width="150px"></a>
    </nav>
    <section id="inscription-connexion-user">
        <fieldset class="container-form-connexion">
            <h1>Inscription</h1>
            <form action="#" method="post">
                <div class="space-center-elements">
                    <input type="email" id="courriel" name="user_email" placeholder="Courriel" class="size-input-connexion" required>
                </div>
                <div class="space-center-elements">
                    <input type="text" id="pseudo" name="user_pseudonyme" placeholder="Pseudo" class="size-input-connexion" required>
                </div>
                <div class="space-center-elements">
                    <input type="password" id="password" name="user_password" placeholder="Mot de passe" class="size-input-connexion" required>
                </div>
                <button type="submit" class="style-button">S'incrire</button>
            </form>
            <h2><a href="./page-connexion.php" class="subsribe-if-no-account">Se connecter</a></h2>
        </fieldset>
    </section>
</body>

</html>