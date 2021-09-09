            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">Liste des articles</h3>
                    <div class="table-data__tool">
                        <div class="table-data__tool-right ml-auto">
                            <a href="/admin/creer-un-article/" class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>Créer un article
                            </a>
                        </div>
                    </div>
                    <div class="ajax-form__alert" style="display: none;"></div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Auteur</th>
                                    <th>Créé le</th>
                                    <th>Modifié le</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="post-list">
                                <?php
                                foreach ($data['postlist'] as $key => $post) {
                                    if (is_int($key)) {
                                        echo '<tr class="tr-shadow post" data-id="' . $post['id'] . '">';
                                        echo    '<td>' . $post['title'] . '</td>';
                                        echo    '<td>' . "{$post['author_first_name']} {$post['author_last_name']}" . '</td>';
                                        echo    '<td><span class="block-email">' . $post['creation_date_fr'] . '</span></td>';
                                        echo    '<td><span class="block-email">' . $post['update_date_fr'] . '</span></td>';
                                        echo    '<td>';
                                        echo        '<div class="table-data-feature">';
                                        echo            '<a href="/admin/editer-un-article/' . $post['id'] . '/" class="item" title="Éditer"><i class="zmdi zmdi-edit"></i></a>';
                                        echo            '<a href="#delete-post" class="item" data-toggle="modal" data-target="#staticBackdrop" title="Supprimer"><i class="zmdi zmdi-delete"></i></a>';
                                        echo        '</div>';
                                        echo    '</td>';
                                        echo '</tr>';
                                        echo '<tr class="spacer"><td class="d-none" colspan="5"></td></tr>';
                                    }
                                } ?>
                            </tbody>
                        </table>
                    </div>
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
