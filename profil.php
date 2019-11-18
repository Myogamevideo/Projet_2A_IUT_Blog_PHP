<?php include('haut.php'); ?>
<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5"> Profil :</h1>
        <?php
        $req = $bdd->prepare('select * from membres where pseudo=?');
        $req->execute(array($_SESSION['pseudo']));
        $donne = $req->fetch();
        $date = date("d/m/Y");
        $date_inscription = date_create($donne['date_inscription']);
        $date_inscription = date_format($date_inscription,'d/m/Y');
        echo '<form method="POST" action="profil.php">';
        ?>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Colonne</th>
                    <th scope="col">Valeur</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">pseudo</th>
                    <td><input name="pseudo" class="form-control" value="<?php echo $donne['pseudo']; ?>" /></td>
                </tr>
                <tr>
                    <th scope="row">email</th>
                    <td><input name="email" class="form-control" value="<?php echo $donne['email']; ?>" /></td>
                </tr>
                <tr>
                    <th scope="row">date_inscription</th>
                    <td><input name="date_inscription" class="form-control" disabled="disabled" value="<?php echo $date_inscription; ?>" /></td>
                </tr>
                <tr>
                    <th scope="row">création_du_compte_depuis</th>
                    <td><input name="date_inscription" class="form-control" disabled="disabled" value="<?php echo ($date-$date_inscription); ?> jours" /></td>
                </tr>
                <tr>
                    <th scope="row">status</th>
                    <td><input name="status" class="form-control" disabled="disabled" value="<?php echo $donne['status']; ?>" /></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-lg btn-primary btn-block">Modifier</button>
        </form>
        
        <div class="alert alert-warning">
            <?php
            if(isset($_POST['pseudo']) && isset($_POST['email']) && $_POST['pseudo']!=NULL && $_POST['email']!=NULL){
                $req = $bdd->prepare('select count(*) as nbr from membres where pseudo=?');
                $req->execute(array($_POST['pseudo']));
                $donne = $req->fetch(PDO::FETCH_ASSOC);
                if($donne['nbr'] != 0){
                    echo '<strong>Information : </strong> pseudo dejà utilisé';
                }else{
                    $req = $bdd->prepare('update membres set pseudo=:pseudo, email=:email where pseudo='.$_POST['pseudo'].'');
                    $req->execute(array('pseudo' => $_POST['pseudo'],
                    'email' => $_POST['email'],
                    ));
                    header('location: profil.php');     
                }
            }else{
                echo '<strong>Information : </strong> Un ou plusieurs champs sont vide';
            }
            ?>
        </div>
        <h3> Liste des commentaires :</h3>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">titre_billets</th>
                    <th scope="col">auteur</th>
                    <th scope="col">commentaire</th>
                    <th scope="col">date_commentaire</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $reponse = $bdd->prepare('select C.id , B.titre , C.auteur , C.commentaire , C.date_commentaire from billets B , commentaires C where C.id_billet=B.id and C.auteur=?');
                $reponse->execute(array($_SESSION['pseudo']));
                while($donnees = $reponse->fetch()){
                    echo 
                    '<tr>
                        <td>'.$donnees['titre'].'</td>
                        <td>'.$donnees['auteur'].'</td>
                        <td>'.$donnees['commentaire'].'</td>
                        <td>'.$donnees['date_commentaire'].'</td>
                        <td><form method="POST" action="deletecommentaires_copy2.php?id='.$donnees['id'].'"> <input type="submit" value="Supprimer ce commentaire"/></form></td>
                    </tr>';
                }
                $reponse->closeCursor();
                ?>
            </tbody>
        </table>
    </div>
</main>
<?php include('bas.php'); ?>
