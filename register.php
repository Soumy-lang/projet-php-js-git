<!DOCTYPE html>
<html lang="fr">
    <?php include "head.php"; ?>
    <body>
        <section class="title"><h1>Inscription à la banque en ligne</h1></section>
        <div class="alert" id="alert">
            <?php if(isset($_GET['message'])): ?>
                <?= htmlspecialchars($_GET['message']); ?>
            <?php endif; ?>
        </div><br>
        <sction class="form-only">
        <!-- <div class="container"> -->
            <div class="form-section" style="width: 500px">
            <form method="POST" action="php-validation/register.php"> 
                <div class="form-group"> 
                    <label for="nom">Nom</label> 
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom" required> 
                </div> 
                <div class="form-group"> 
                    <label for="prenom">Prénom</label> 
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom" required> 
                </div> 
                <div class="form-group"> 
                    <label for="telephone">Téléphone</label> 
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Téléphone"> 
                </div> 
                <div class="form-group"> 
                    <label for="email">Email</label> 
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"> 
                </div> 
                <div class="form-group"> 
                    <label for="mdp">Mot de passe</label> 
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required> 
                    <div id="alert-response-password" class="danger-alert"></div>
                </div> 
                <div class="form-group"> 
                    <label for="account_type">Type de compte</label> 
                    <select class="form-control" id="account_type" name="account_type" required> 
                        <option value="courant">Courant</option> 
                        <option value="epargne">Épargne</option> 
                        <option value="entreprise">Entreprise</option> 
                    </select> 
                    <div id="alert-response-account" class="danger-alert"></div>
                </div> 
                <button type="submit" class="btn btn-primary">Inscription</button> 
            </form>
            </div>
        </section>
        
        <p>Déjà inscrit ? <a href="login.php" style="color: blue;">Connectez-vous ici</a></p>

    </body>
</html>
