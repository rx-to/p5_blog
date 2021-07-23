            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">Liste des articles</h3>
                    <div class="table-data__tool">
                        <div class="table-data__tool-right ml-auto">
                            <a href="/admin/creer-un-article/" class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>Créer un article</a>
                        </div>
                    </div>
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
                            <tbody>
                                <?php
                                foreach ($data['postlist'] as $key => $post) {
                                    if (is_int($key)) {
                                        echo '<tr class="tr-shadow">';
                                        echo    '<td>' . $post['title'] . '</td>';
                                        echo    '<td>' . "{$post['author_first_name']} {$post['author_last_name']}" . '</td>';
                                        echo    '<td><span class="block-email">' . $post['creation_date_fr'] . '</span></td>';
                                        echo    '<td><span class="block-email">' . $post['update_date_fr'] . '</span></td>';
                                        echo    '<td>';
                                        echo        '<div class="table-data-feature">';
                                        echo            '<a href="/admin/editer-un-article/' . $post['id'] . '/" class="item" data-toggle="tooltip" data-placement="top" title="Edit"><i class="zmdi zmdi-edit"></i></a>';
                                        echo            '<button class="item" data-toggle="tooltip" data-placement="top" title="Delete"><i class="zmdi zmdi-delete"></i></button>';
                                        echo        '</div>';
                                        echo    '</td>';
                                        echo '</tr>';
                                        echo '<tr class="spacer"></tr>';
                                    }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>