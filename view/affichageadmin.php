<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5"> Page administration :</h1>
        <h3> Liste des articles :</h3>
        <form method="POST" action="index.php?action=admin">
            <input type="search" name="recherche" class="form-control" placeholder="Recherche un article ..." />
            <button type="submit" class="btn btn-lg btn-primary btn-block">Search</button>
        </form>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">titre</th>
                    <th scope="col">contenu</th>
                    <th scope="col">date_creation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($news) > 0) {
                    foreach ($listearticle as $key => $donnees) {
                        echo
                            '<tr>
                        <td>' . $donnees->getid() . '</td>
                        <td>' . $donnees->gettitre() . '</td>
                        <td style="max-height: 2em;
                        max-width: 30em;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;">' . $donnees->getcontenu() . '</td>
                        <td>' . $donnees->getdate_creation() . '</td>
                        <td><form method="POST" action="index.php?action=delArticle&id_billet=' . $donnees->getid() . '"> <input type="submit" value="Supprimer cette article"/></form></td>
                        <td><form method="POST" action="index.php?action=pagemodifiernews&id_billet=' . $donnees->getid() . '"> <input type="submit" value="Modifier cette article"/></form></td>
                    </tr>';
                    }
                } else {
                    echo 'Aucun résultat pour: ' . $recherche . '...';
                }
                ?>
            </tbody>
        </table>
        <?php
        echo '<form method="POST" action="index.php?action=pageajouternews"> <input type="submit" value="Ajouter un article"/></form>';
        ?>
        <h3> Liste des commentaires :</h3>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">id_billets</th>
                    <th scope="col">titre_billets</th>
                    <th scope="col">#</th>
                    <th scope="col">auteur</th>
                    <th scope="col">commentaire</th>
                    <th scope="col">date_commentaire</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($comments as $donnees) {
                    echo
                        '<tr>
                        <td>' . $donnees->getid_billet() . '</td>
                        <td>' . $donnees->getid() . '</td>
                        <td>' . $donnees->getauteur() . '</td>
                        <td>' . $donnees->getcommentaire() . '</td>
                        <td>' . $donnees->getdate_commentaire() . '</td>
                        <td><form method="POST" action="index.php?id_commentaire=' . $donnees->getid() . '&action=delCommentaireAdmin"> <input type="submit" value="Supprimer ce commentaire"/></form></td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
        <h3> Liste des membres :</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>#</td>
                    <td>pseudo</td>
                    <td>email</td>
                    <td>date_inscription</td>
                    <td>statu</td>
                    <td>commentaire</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($membre as $donnees) {
                    echo
                        '<tr>
                        <td>' . $donnees->getid() . '</td>
                        <td>' . $donnees->getpseudo() . '</td>
                        <td>' . $donnees->getemail() . '</td>
                        <td>' . $donnees->getdate_inscription() . '</td>
                        <td>' . $donnees->getstatu() . '</td>';
                    echo '<td><form method="POST" action="index.php?action=delMembre&id_membre=' . $donnees->getid() . '&pseudo=' . $donnees->getpseudo() . '"> <input type="submit" value="Supprimer ce membre"/></form></td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</main>
