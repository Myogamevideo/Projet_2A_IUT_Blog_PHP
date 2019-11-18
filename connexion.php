<?php include('haut.php'); ?>
<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="h3 mb-3 font-weight-normal mt-5"> Connexion :</h1>
        <form method="POST" action="connexion.php" class="form-signin">
        <label for="pseudo" class="sr-only">Pseudo : </label><input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="Pseudo" required="" autofocus=""/>
        <label for="mdp" class="sr-only">Mot de passe : </label><input class="form-control" placeholder="Mot de passe" required="" type="password" name="mdp" id="mdp"/>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="Connexion automatique" name="case" id="case"> Connexion automatique
            </label>
        </div>
        <button type="submit" class="btn btn-lg btn-primary btn-block">Connexion</button>
        </form>

        <div class="alert alert-warning">
        <?php
        if(isset($_COOKIE['pseudo']) && isset($_COOKIE['mdp']) && isset($_COOKIE['status'])){
            $req = $bdd->prepare('select pass from membres where pseudo=?');
            $req->execute(array($_COOKIE['pseudo']));
            $donne = $req->fetch();
            if($_COOKIE['mdp'] == $donne['pass']){
                $req = $bdd->prepare('select id,status from membres where pseudo=?');
                $req->execute(array($_COOKIE['pseudo']));
                $donne = $req->fetch();
                $_SESSION['id']=$donne['id'];
                $_SESSION['pseudo']=$_COOKIE['pseudo'];
                $_SESSION['status']=$donne['status'];
                header('location: index.php');
            }
        }

        if(isset($_POST['pseudo']) && isset($_POST['mdp']) && $_POST['pseudo']!=NULL and $_POST['mdp']!=NULL){
            $req = $bdd->prepare('select count(*) as nbr from membres where pseudo=?');
            $req->execute(array($_POST['pseudo']));
            $donne = $req->fetch(PDO::FETCH_ASSOC);
            if($donne['nbr'] != 0){
                $req = $bdd->prepare('select pass from membres where pseudo=?');
                $req->execute(array($_POST['pseudo']));
                $donne = $req->fetch();
                $verify = password_verify($_POST['mdp'],$donne['pass']);
                if($verify == true){
                    $req = $bdd->prepare('select id,status from membres where pseudo=?');
                    $req->execute(array($_POST['pseudo']));
                    $donne = $req->fetch();
                    $_SESSION['id']=$donne['id'];
                    $_SESSION['pseudo']=$_POST['pseudo'];
                    $_SESSION['status']=$donne['status'];
                    echo 'Connectée';?> <br> <?php
                    if($_POST['case'] == 'on'){
                        setcookie('pseudo',$_POST['pseudo'],time()+3600,null,null,false,true);
                        $req = $bdd->prepare('select pass,status from membres where pseudo=?');
                        $req->execute(array($_POST['pseudo']));
                        $donne = $req->fetch();
                        setcookie('mdp',$donne['pass'],time()+3600,null,null,false,true);
                        setcookie('status',$donne['status'],time()+3600,null,null,false,true);
                        header('location: index.php');
                    }else{
                        header('location: index.php');
                    }
                }else{
                    echo '<strong>Information : </strong> Mauvais identifiant ou mot de passe';?> <br> <?php
                }
            }else{
                echo '<strong>Information : </strong> Mauvais identifiant ou mot de passe';?> <br> <?php
            }
        }else{
            echo '<strong>Information : </strong> Un ou plusieurs champs sont vide';?> <br> <?php
        }
        ?>
        </div>
    </div>
</main>
<?php include('bas.php'); ?>

