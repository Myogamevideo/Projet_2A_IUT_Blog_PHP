<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5"> Modification de la news :</h1>
        <?php
        $donne = $article->fetch();

        echo '<h2>   (' . $articleID . ') ' . $donne['titre'] . '</h2>';
        echo '<form method="POST" action="admin.php?id_billet=' . $articleID . '&action=modifierNews">';
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
                    <td><input type="text" name="id" id="id" disabled="disabled" value="<?php echo $articleID; ?>" class="form-control" /></td>
                </tr>
                <tr>
                    <th scope="row">titre</th>
                    <td>varchar (255)</td>
                    <td><textarea name="titre" rows="5" cols="5" class="form-control" /><?php echo $donne['titre']; ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row">contenu</th>
                    <td>text</td>
                    <td>
                        <button type="button" class="btn btn-primary" disabled="disabled"><strong>[b] Texte en gras [/b]</strong></button>
                        <button type="button" class="btn btn-secondary" disabled="disabled"><em>[i] Texte en italique [/i]</em></button>
                        <button type="button" class="btn btn-warning" disabled="disabled"><span style="color:red">[color=red] Texte en rouge [/color]</span></button>
                        <button type="button" class="btn btn-link" disabled="disabled"><a href="">Lien : http://...</a></button>
                        <textarea name="contenu" rows="5" cols="5" class="form-control" /><?php echo $donne['contenu']; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row">date_creation</th>
                    <td>datetime</td>
                    <td><input type="text" name="date_creation" id="date_creation" disabled="disabled" value="<?php echo $donne['date_creation']; ?>" /></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-lg btn-primary btn-block">Modifier</button>
    </div>
</main>