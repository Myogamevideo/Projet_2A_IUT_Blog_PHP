<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="h3 mb-3 font-weight-normal mt-5"> Connexion :</h1>
        <form method="POST" action="index.php?action=connexion" class="form-signin">
            <label for="pseudo" class="sr-only">Pseudo : </label><input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="Pseudo" required="" autofocus="" />
            <label for="password" class="sr-only">Mot de passe : </label><input class="form-control" placeholder="Mot de passe" required="" type="password" name="password" id="password" />
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="Connexion automatique" name="case" id="case"> Connexion automatique
                </label>
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Connexion</button>
        </form>
    </div>
</main>