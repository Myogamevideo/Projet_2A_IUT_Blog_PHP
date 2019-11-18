<?php include('haut.php'); ?>
<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="h3 mb-3 font-weight-normal mt-5"> Inscription :</h1>
        <form method="POST" action="inscription.php" class="form-signin">
        <label for="pseudo" class="sr-only">Pseudo : </label><input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="Pseudo" required="" autofocus=""/>
        <label for="mdp" class="sr-only">Mot de passe : </label><input type="password" name="mdp" id="mdp" class="form-control" placeholder="Mot de passe" required="" />
        <label for="confi_mdp" class="sr-only">Confirmation : </label><input type="password" name="confi_mdp" id="confi_mdp" class="form-control" placeholder="Confirmation du mot de passe" required="" />
        <label for="email" class="sr-only">Email : </label><input type="text" name="email" id="email" class="form-control" placeholder="Email" required=""/>
        <button type="submit" class="btn btn-lg btn-primary btn-block">Inscription</button>
        </form>

        <div class="alert alert-warning">
        <?php
        if(isset($_POST['pseudo']) && isset($_POST['mdp']) && isset($_POST['confi_mdp']) && isset($_POST['email']) && $_POST['pseudo']!=NULL && $_POST['mdp']!=NULL && $_POST['confi_mdp']!=NULL && $_POST['email']!=NULL){
            $req = $bdd->prepare('select count(*) as nbr from membres where pseudo=?');
            $req->execute(array($_POST['pseudo']));
            $donne = $req->fetch(PDO::FETCH_ASSOC);
            if($donne['nbr'] != 0){
                echo '<strong>Information : </strong> Pseudo dejà utilisé';?>  <?php
            }else{
                if($_POST['confi_mdp'] != $_POST['mdp']){
                    echo '<strong>Information : </strong> Mot de passe différent par rapport à la confimration';?>  <?php
                }else{
                    if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$_POST['email'])){
                            $pass_hach = password_hash($_POST['mdp'],PASSWORD_DEFAULT);
                            $req = $bdd->prepare('insert into membres (pseudo,pass,email,date_inscription,status) values (:pseudo,:pass,:email,now(),:status)');
                            $req->execute(array('pseudo' => $_POST['pseudo'],
                            'pass' => $pass_hach,
                            'email' => $_POST['email'],
                            'status'  => 'null',
                            ));
                            header('location: connexion.php');
                    }else{
                        echo '<strong>Information : </strong> Adresse email non valide';?>  <?php
                    }
                }
            }
        }else{
            echo '<strong>Information : </strong> Un ou plusieurs champs sont vide';?>  <?php
        }
        ?>
        </div>
    </div>
</main>
<?php include('bas.php'); ?>

