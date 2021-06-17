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
                    <form id="commentForm" class="ajax-form">
                        <input type="hidden" name="action" value="postComment">
                        <input type="hidden" name="comment_id" value="0">
                        <input type="hidden" name="post_id" value="<?= $data['post']['id'] ?>">
                        <input type="hidden" name="reply_to_comment_id" value="0">
                        <div class="control-group">
                            <div class="ajax-form__alert"></div>
                            <img src="/upload/avatars/avatar-1.png" alt="Avatar de prenom nom" class="comment__author-avatar">
                            <div class="form-group floating-label-form-group controls">
                                <label>Votre commentaire</label>
                                <textarea class="form-control" id="comment" name="comment" rows="5" placeholder="Votre commentaire..." required data-validation-required-message="Veuillez saisir votre commentaire."></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div id="success"></div>
                        <div class="text-right">
                            <button class="btn btn-primary" id="sendMessageButton" type="submit">Envoyer</button>
                        </div>
                    </form>

                    <div class="comment-list">
                        <?php
                        echo '<h2>Commentaires (' . $data['post']['number_of_comments'] . ')</h2>';
                        if ($data['post']['number_of_comments'] > 0) {
                            foreach ($data['post']['comments'] as $comment) {
                                echo '<div id="comment-' . $comment['id'] . '" class="comment" data-id="' . $comment['id'] . '">';
                                echo        '<div class="actions">';
                                echo            '<i class="fas fa-ellipsis-v comment__nav-trigger"></i>';
                                echo            '<div class="actions__wrapper">';
                                echo                '<ul class="actions__list"0>';
                                echo                    '<li><a href="#reply-to-comment"">Répondre</a></li>';
                                echo                    '<li><a href="#edit-comment">Modifier</a></li>';
                                echo                    '<li><a href="#delete-comment" data-toggle="modal" data-target="#staticBackdrop">Supprimer</a></li>';
                                echo                    '<li><a href="#report-comment" data-toggle="modal" data-target="#staticBackdrop">Signaler</a></li>';
                                echo                '</ul>';
                                echo            '</div>';
                                echo        '</div>';
                                echo     '<a href="/utilisateur/' . $comment['user_slug'] . '/">';
                                echo        '<img src="/upload/avatars/' . $comment['author_avatar'] . '" alt="Avatar de prenom nom" class="comment__author-avatar">';
                                echo     '</a>';
                                echo     '<header>';
                                echo         '<h3 class="comment__author-name"><a href="/utilisateur/' . $comment['user_slug'] . '/">' . $comment['author_first_name'] . ' ' . $comment['author_last_name'] . '</a></h3>';
                                echo         '<div class="comment__date">' . $comment['creation_date_fr'] . '</div>';
                                echo     '</header>';
                                echo     '<div id="comment__content-' . $comment['id'] . '" class="comment__content">' . nl2br($comment['content']) . '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>Soyez la première personne à commenter cet article ! 😜</p>';
                        }
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
</article>