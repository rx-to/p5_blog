<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <?= $data['post']['content'] ?>
                <nav class="d-md-flex justify-content-between mt-5 text-center article-nav">
                    <a href="<?= isset($data['post']['previous']) ?  "/article/{$data['post']['previous']}/" : '#previous' ?>" class="d-block d-md-inline-block<?= isset($data['post']['previous']) ? '' : ' disabled' ?>">« Article précédent</a>
                    <a href="/articles/" class="d-block d-md-inline-block">Retour aux articles</a>
                    <a href="<?= isset($data['post']['next'])     ?  "/article/{$data['post']['next']}/"     : '#next' ?>" class="d-block d-md-inline-block<?= isset($data['post']['next']) ? '' : ' disabled' ?>">Article suivant »</a>
                </nav>
            </div>
        </div>
    </div>
</article>