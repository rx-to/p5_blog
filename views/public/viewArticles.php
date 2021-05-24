<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?php foreach ($data['postlist'] as $key => $post) {
                if (is_int($key)) {
                    $commentWord = 'commentaire' . ($post['number_of_comments'] > 1 ? 's' : '');
            ?>
                    <div class="post-preview">
                        <a href="/article/<?= $post['slug'] ?>/">
                            <h2 class="post-title"><?= $post['title'] ?></h2>
                            <h3 class="post-subtitle"><?= $post['introduction'] ?></h3>
                        </a>
                        <p class="post-meta">
                            Posté le <?= $post['creation_date_fr'] ?> par
                            <a href="/utilisateur/<?= $post['user_slug'] ?>/"><?= $post['first_name'] . ' ' . $post['last_name'] ?></a>
                        </p>
                        <p class="post-comments"><i class="far fa-comment mr-3"></i><?= "{$post['number_of_comments']} $commentWord" ?></p>
                    </div>

            <?php
                    if ($key < count($data['postlist']) - 2)
                        echo '<hr>';
                }
            } ?>
            <!-- Pager-->
            <div class="text-center">
                <ul class="pager">
                    <?php
                    if ($data['postlist']['number_of_pages'] > 1 && $data['postlist']['page'] - 1 >= 1)
                        echo '<li class="arrow"><a href="/articles/' . ($data['postlist']['page'] - 1) . '/"><i class="fas fa-arrow-left"></i></a></li>';

                    $dots = false;
                    for ($i = 1; $i <= $data['postlist']['number_of_pages']; $i++) {
                        echo '<li' . ($data['postlist']['page'] == $i ? ' class="active"' : '') . '><a href="/articles/' . $i . '/">' . $i . '</a></li>';
                    }
                    if ($data['postlist']['number_of_pages'] > 1 && $data['postlist']['page'] + 1 <= $data['postlist']['number_of_pages'])
                        echo '<li class="arrow"><a href="/articles/' . ($data['postlist']['page'] + 1) . '/"><i class="fas fa-arrow-right"></i></a></li>';
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>