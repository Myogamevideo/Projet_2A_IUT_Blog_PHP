<?php include('haut.php'); ?>
<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5"> Modification de la news :</h1>
        <?php
        $req = $bdd->prepare('select * from billets where id=?');
        $req->execute(array($_GET['id']));
        $donne = $req->fetch();

        echo '<h2>   ('.$_GET['id'].') '.$donne['titre'].'</h2>';
        echo '<form method="POST" action="modifiernews.php?id='.$_GET['id'].'">';
        ?>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Colonne</th>
                    <th scope="col">Type</th>
                    <th scope="col">Valeur</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">id</th>
                    <td>int (11)</td>
                    <td><input type="text" name="id" id="id" disabled="disabled" value="<?php echo $_GET['id']; ?>" class="form-control"/></td>
                </tr>
                <tr>
                    <th scope="row">titre</th>
                    <td>varchar (255)</td>
                    <td><textarea name="titre" rows="5" cols="5" class="form-control"/><?php echo $donne['titre']; ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row">contenu</th>
                    <td>text</td>
                    <td><textarea name="contenu" rows="5" cols="5" class="form-control"/><?php echo $donne['contenu']; ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row">date_creation</th>
                    <td>datetime</td>
                    <td><input type="text" name="date_creation" id="date_creation" disabled="disabled" value="<?php echo $donne['date_creation']; ?>"/></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-lg btn-primary btn-block">Modifier</button>

        <div class="alert alert-warning">
            <?php
            if(isset($_POST['titre']) && isset($_POST['contenu']) && $_POST['titre']!=NULL && $_POST['contenu']!=NULL){
                $req = $bdd->prepare('select count(*) as nbr from billets where titre=?');
                $req->execute(array($_POST['titre']));
                $donne = $req->fetch(PDO::FETCH_ASSOC);
                if($donne['nbr'] != 0){
                    echo '<strong>Information : </strong> Titre dejà utilisé';
                }else{
                    $req = $bdd->prepare('update billets set titre=:titre, contenu=:contenu, date_creation=now() where id='.$_GET['id'].'');
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
