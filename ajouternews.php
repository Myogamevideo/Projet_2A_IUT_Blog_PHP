<?php include('haut.php'); ?>
<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5"> Ajouter une news :</h1>
        <form method="POST" action="ajouternews.php">
        <label for="titre" class="sr-only">Titre : </label><input type="text" name="titre" id="tritre" class="form-control" placeholder="Titre" required="" autofocus=""/>
        <label for="contenu" class="sr-only">Contenu : </label><textarea name="contenu" id="contenu" rows="10" cols="50" class="form-control" placeholder="Contenu de l'article" required="" autofocus=""></textarea>
        <button type="submit" class="btn btn-lg btn-primary btn-block">Ajouter</button>
        </form>

        <div class="alert alert-warning">
            <?php
            if(isset($_POST['titre']) && isset($_POST['contenu']) && $_POST['titre']!=NULL && $_POST['contenu']!=NULL){
                $_POST['contenu'] = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $_POST['contenu']);
                $_POST['contenu'] = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $_POST['contenu']);
                $_POST['contenu'] = preg_replace('#\[color=(red|green|blue|yellow|purple|olive)\](.+)\[/color\]#isU', '<span style="color:$1">$2</span>', $_POST['contenu']);
                $_POST['contenu'] = preg_replace('#http://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $_POST['contenu']);
                $req = $bdd->prepare('select count(*) as nbr from billets where titre=?');
                $req->execute(array($_POST['titre']));
                $donne = $req->fetch(PDO::FETCH_ASSOC);
                if($donne['nbr'] != 0){
                    echo '<strong>Information : </strong> Titre dejà utilisé';
                }else{
                    $req = $bdd->prepare('insert into billets (titre,contenu,date_creation) values (:titre,:contenu,now())');
                    $req->execute(array('titre' => $_POST['titre'],
                    'contenu' => $_POST['contenu'],
                    ));
                    header('location: admin.php');     
                }
            }else{
                echo '<strong>Information : </strong> Un ou plusieurs champs sont vide';
            }
            ?>
        </div>
    </div>
</main>
<?php include('bas.php'); ?>

