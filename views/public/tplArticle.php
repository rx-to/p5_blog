<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Retour</button>
                <button type="button" class="btn btn-primary btn-yes" data-dismiss="modal">Oui</button>
            </div>
        </div>
    </div>
</div>
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
                <hr class="mt-0">
                <section class="comments-section">
                    <?php if (isset($curUser['id'])) { ?>
                        <form id="commentForm" class="ajax-form">
                            <input type="hidden" name="action" value="postComment">
                            <input type="hidden" name="comment_id" value="0">
                            <input type="hidden" name="post_id" value="<?= $data['post']['id'] ?>">
                            <div class="control-group">
                                <div class="ajax-form__alert" style="display: none;"></div>
                                <img src="/upload/avatars/avatar-1.png" alt="Avatar de prenom nom" class="comment__author-avatar">
                                <div class="form-group floating-label-form-group controls">
                                    <label>Votre commentaire</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="5" placeholder="Votre commentaire..." required></textarea>
                                </div>
                            </div>
                            <div id="success"></div>
                            <div class="text-right">
                                <button class="btn btn-primary" id="sendMessageButton" type="submit">Envoyer</button>
                            </div>
                        </form>
                    <?php } ?>
                    <div class="comment-list">
                        <?php
                        $controllerPost = new ControllerPost();
                        echo $controllerPost->generateCommentList($data['post']['id']);
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
</article>