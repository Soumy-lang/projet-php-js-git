<!DOCTYPE html>
<html lang="fr">
<?php include "head.php"; ?>
<body>
    <section class="title"><h1>Bienvenue à la banque en ligne</h1></section>
    <p>Connectez-vous à votre espace personnel ou inscrivez-vous si vous n'avez pas encore de compte.</p>
    <div class="alert" id="alert">
            <?php if(isset($_GET['message'])): ?>
                <?= htmlspecialchars($_GET['message']); ?>
            <?php endif; ?>
        </div><br>
    <h2>Connexion</h2>
    <sction class="form-only">
        <!-- <div class="container"> -->
            <div class="form-section" style="width: 500px">
                <form method="POST" action="php-validation/login.php"> 
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
            </div>
        <!-- </div>  -->
    </section>
    <p>Pas encore inscrit ? <a href="register.php" style="color: blue;">Créez un compte ici</a></p>

</body>
</html>
