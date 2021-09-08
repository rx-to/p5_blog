<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <section class="text-center">
                <h2 class="underline underline-center text-center">Bienvenue sur mon blog !</h2>
                <img src="/assets/themes/clean-blog/img/developpeur.jpg" alt="Développeur web" class="img-fluid">
                <br><br>
                <p>Passionné d'informatique et particulièrement de développement web, je prends plaisir à vous partager mes connaissances et à parler d'actualité informatique !</p>
                <p><a href="/upload/miscellaneous/cv-francois-espiasse.pdf" class="btn btn-primary text-decoration-none" target="_blank" rel="noopener"><i class="fa fa-download mr-3"></i>Télécharger mon CV</a></p>
            </section>

            <section>
                <h2 class="underline">Les derniers articles</h2>
                <?php foreach ($data['postlist'] as $key => $post) {
                    if (is_int($key)) {
                        $commentWord = 'commentaire' . ($post['number_of_comments'] > 1 ? 's' : '');
                ?>
                        <div class="post-preview">
                            <a href="/article/<?= $post['slug'] ?>/">
                                <h3 class="post-title"><?= $post['title'] ?></h3>
                                <h4 class="post-subtitle"><?= $post['introduction'] ?></h4>
                            </a>
                            <p class="post-meta">
                                Posté le <?= $post['creation_date_fr'] . ' par ' . $post['author_first_name'] . ' ' . $post['author_last_name'] ?></a>
                            </p>
                            <p class="post-comments"><i class="far fa-comment mr-3"></i><?= "{$post['number_of_comments']} $commentWord" ?></p>
                        </div>

                <?php
                        if ($key < count($data['postlist']) - 2)
                            echo '<hr>';
                    }
                } ?>
            </section>
        </div>
    </div>
</div>
