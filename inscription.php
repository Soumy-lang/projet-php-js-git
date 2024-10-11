<!DOCTYPE html>
<html lang="fr">
    <?php include "head.php"; ?>
    <body>
        <section class="title"><h1>Inscription à la banque en ligne</h1></section>
        <section class="Form-content">
            <form method="POST" action="ajouter_client.php"> 
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
                </div> 
                <button type="submit" class="btn btn-primary">Inscription</button> 
            </form>
        </section>
        
        <p>Déjà inscrit ? <a href="connexion.php">Connectez-vous ici</a></p>

    </body>
</html>
