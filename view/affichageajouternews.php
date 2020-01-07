<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5"> Ajouter une news :</h1>
        <form method="POST" enctype="multipart/form-data" action="index.php?action=ajouterNews">
            <label for="titre" class="sr-only">Titre : </label><input type="text" name="titre" id="tritre" class="form-control" placeholder="Titre" required="" autofocus="" />
            <button type="button" class="btn btn-primary" disabled="disabled"><strong>[b] Texte en gras [/b]</strong></button>
            <button type="button" class="btn btn-secondary" disabled="disabled"><em>[i] Texte en italique [/i]</em></button>
            <button type="button" class="btn btn-warning" disabled="disabled"><span style="color:red">[color=red] Texte en rouge [/color]</span></button>
            <button type="button" class="btn btn-link" disabled="disabled"><a href="">Lien : http://...</a></button>
            <label for="contenu" class="sr-only">Contenu : </label><textarea name="contenu" id="contenu" rows="10" cols="50" class="form-control" placeholder="Contenu de l'article" required="" autofocus=""></textarea>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Ajouter</button>
        </form>
    </div>
</main>