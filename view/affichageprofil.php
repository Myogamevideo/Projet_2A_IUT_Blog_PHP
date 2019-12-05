<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5"> Profil :</h1>
        <?php
        $date = date("d/m/Y");
        $date_inscription = date_create($profil['date_inscription']);
        $date_inscription = date_format($date_inscription, 'd/m/Y');
        echo '<form method="POST" action="membre.php?action=profil">';
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
                    <td><input name="pseudo" class="form-control" value="<?php echo $profil['pseudo']; ?>" /></td>
                </tr>
                <tr>
                    <th scope="row">email</th>
                    <td><input name="email" class="form-control" value="<?php echo $profil['email']; ?>" /></td>
                </tr>
                <tr>
                    <th scope="row">date_inscription</th>
                    <td><input name="date_inscription" class="form-control" disabled="disabled" value="<?php echo $date_inscription; ?>" /></td>
                </tr>
                <tr>
                    <th scope="row">création_du_compte_depuis</th>
                    <td><input name="date_inscription" class="form-control" disabled="disabled" value="<?php echo ($date - $date_inscription); ?> jours" /></td>
                </tr>
                <tr>
                    <th scope="row">statu</th>
                    <td><input name="statu" class="form-control" disabled="disabled" value="<?php echo $profil['statu']; ?>" /></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-lg btn-primary btn-block">Modifier</button>
        </form>

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
                while ($donnees = $comments->fetch()) {
                    echo
                        '<tr>
                        <td>' . $donnees['titre'] . '</td>
                        <td>' . $donnees['auteur'] . '</td>
                        <td>' . $donnees['commentaire'] . '</td>
                        <td>' . $donnees['date_commentaire'] . '</td>
                        <td><form method="POST" action="membre.php?action=profil&id_commentaire=' . $donnees['id'] . '"> <input type="submit" value="Supprimer ce commentaire"/></form></td>
                    </tr>';
                }
                $comments->closeCursor();
                ?>
            </tbody>
        </table>
    </div>
</main>