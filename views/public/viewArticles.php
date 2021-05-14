<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?php foreach ($list as $post) { ?>
                <div class="post-preview">
                    <a href="article/<?= $post['slug'] ?>">
                        <h2 class="post-title"><?= $post['title'] ?></h2>
                        <h3 class="post-subtitle"><?= $post['introduction'] ?></h3>
                    </a>
                    <p class="post-meta">
                        Posté le
                        <a href="#!"><?= $post['author'] ?></a>
                        <?= $post['creation_date_fr'] ?>
                    </p>
                </div>
                <hr>
            <?php } ?>
            <!-- Pager-->
            <div class="clearfix"><a class="btn btn-primary float-right" href="#!">Voir +</a></div>
        </div>
    </div>
</div>