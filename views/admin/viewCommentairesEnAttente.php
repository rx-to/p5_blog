<div class="section__content section__content--p30">
    <div class="container-fluid">
        <!-- DATA TABLE -->
        <h3 class="title-5 m-b-35">Liste des commentaires en attente</h3>
        <div class="ajax-form__alert" style="display: none;"></div>
        <?php if (!empty($data['commentlist'])) { ?>
            <div class="table-responsive table-responsive-data2">
                <table class="table table-data2">
                    <thead>
                        <tr>
                            <th>Auteur</th>
                            <th>Créé le</th>
                            <th>Modifié le</th>
                            <th>Contenu</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="comment-list">
                        <?php
                        foreach ($data['commentlist'] as $key => $comment) {
                            if (is_int($key)) {
                                echo '<tr class="tr-shadow comment" data-id="' . $comment['id'] . '">';
                                echo    '<td>' . "{$comment['author_first_name']} {$comment['author_last_name']}" . '</td>';
                                echo    '<td><span class="block-email">' . $comment['creation_date_fr'] . '</span></td>';
                                echo    '<td><span class="block-email">' . $comment['update_date_fr'] . '</span></td>';
                                echo    '<td>' . Blog\Tools\Util::shortenString($comment['content']) . '</td>';
                                echo    '<td>';
                                echo        '<div class="table-data-feature">';
                                echo            '<a href="/admin/detail-commentaire/' . $comment['id'] . '/" class="item" title="Voir le commentaire"><i class="fas fa-eye"></i></a>';
                                if ($comment['status'] == 0)
                                    echo        '<a href="#validate-comment?getPendingComments()" class="item" data-toggle="modal" data-target="#staticBackdrop" title="Valider"><i class="zmdi zmdi-check"></i></a>';
                                echo            '<a href="#delete-comment" class="item" data-toggle="modal" data-target="#staticBackdrop" title="Supprimer"><i class="zmdi zmdi-delete"></i></a>';
                                echo        '</div>';
                                echo    '</td>';
                                echo '</tr>';
                                echo '<tr class="spacer"><td class="d-none" colspan="5"></td></tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        } else {
            echo '<p>Aucun commentaire en attente de validation pour le moment...</p>';
        }
        ?>
        <!-- END DATA TABLE -->
    </div>
</div>
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