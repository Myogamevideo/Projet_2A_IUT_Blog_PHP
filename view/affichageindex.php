<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5"> Actualités :</h1>
        <div class="blog-post">
            <?php
            foreach ($articles as $news) {
                echo '<a style="text-decoration:none;" class="reinitialise" href="index.php?id_billet=' . $news->getid() . '&action=Article">';
                echo '<div class="container2">';
                echo '<img src="public/images/' . $news->gettitre() . '.jpg" alt="Image : ' . $news->gettitre() . '">';
                echo '<h2 class="blog-post-title">' . $news->gettitre() . '</h2>';
                echo '<p class="blog-post-meta">' . $news->getdate_creation() . '</p>';
                echo '<p 
                                style="max-height: 2em;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;">' . $news->getcontenu() . '</p>';
                echo '</div>';
                echo '</a>';
            }
            ?>
        </div>

        <?php

        for ($i = 1; $i <= $pagesTotales; $i++) {
            if ($i == $pageCourante) {
                echo '<button>' . $i . '</button>';
            } else {
                echo '<a href="index.php?page=' . $i . '"><button>' . $i . '</button></a> ';
            }
        }

        ?>
    </div>
</main>