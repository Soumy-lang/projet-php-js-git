<!DOCTYPE html>
<html lang="fr">
<?php include "head.php"; ?>
<body>
    <h1>Bienvenue à la banque en ligne</h1>
    <p>Connectez-vous à votre espace personnel ou inscrivez-vous si vous n'avez pas encore de compte.</p>
    <h2>Connexion</h2>
    <form method="POST" action="php/connexion.php"> 
        <div class="form-group"> 
            <label for="email">Email</label> 
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required> 
        </div> 
        <div class="form-group"> 
            <label for="mdp">Mot de passe</label> 
            <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required> 
        </div> 
        <button type="submit" class="btn btn-primary">Se connecter</button> 
    </form> 

    <p>Pas encore inscrit ? <a href="inscription.php">Créez un compte ici</a></p>

</body>
</html>
