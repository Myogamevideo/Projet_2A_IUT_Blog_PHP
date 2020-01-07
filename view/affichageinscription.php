<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="h3 mb-3 font-weight-normal mt-5"> Inscription :</h1>
        <form method="POST" action="index.php?action=inscription" class="form-signin">
            <label for="pseudo" class="sr-only">Pseudo : </label><input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="Pseudo" required="" autofocus="" />
            <label for="password" class="sr-only">Mot de passe : </label><input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required="" />
            <label for="confi_password" class="sr-only">Confirmation : </label><input type="password" name="confi_password" id="confi_password" class="form-control" placeholder="Confirmation du mot de passe" required="" />
            <label for="email" class="sr-only">Email : </label><input type="text" name="email" id="email" class="form-control" placeholder="Email" required="" />
            <button type="submit" class="btn btn-lg btn-primary btn-block">Inscription</button>
        </form>
    </div>
</main>