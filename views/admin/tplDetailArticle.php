                <div class="section__content section__content--p30 post" <?= $data['post']['id'] ? 'data-id="' . $data['post']['id'] . '"' : '' ?>>
                    <div class="container-fluid">
                        <div class="card">
                            <form action="/<?= $id == 0 ? 'creer-un-article' : 'editer-un-articler' ?>" method="post" enctype="multipart/form-data" class="form-horizontal ajax-form">
                                <div class="card-body card-block">
                                    <input type="hidden" name="action" value="<?= $id == 0 ? 'create' : 'edit' ?>Post">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <input type="hidden" name="image" value="<?= $data['post']['image'] ?? '' ?>">
                                    <div class="ajax-form__alert"></div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="status" class="form-control-label">Statut <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="0" <?= isset($data['post']['status']) && $data['post']['status'] == 0 ? ' selected' : '' ?>>Hors ligne</option>
                                                <option value="1" <?= isset($data['post']['status']) && $data['post']['status'] == 1 ? ' selected' : '' ?>>En ligne</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="title" class="form-control-label">Titre <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="title" name="title" placeholder="Titre..." class="form-control" <?= isset($data['post']['introduction']) ? 'value="' . $data['post']['title'] . '"' : '' ?> required>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="uploadImage" class="form-control-label">Bandeau</label>
                                        </div>
                                        <div class="col-12 col-md-9 uploadImage-container">
                                            <?php
                                            if (isset($data['post']['image']) && $data['post']['image']) {
                                                echo '<a href="#delete-image" class="img-container" title="Supprimer l\'image" data-toggle="modal" data-target="#staticBackdrop">';
                                                echo     '<img src="/upload/post/' . ($data['post']['image'] ?? '') . '" alt="Bandeau de l\'article «  ' . ($data['post']['title'] ?? '') . ' »" class="img-fluid max-height-300">';
                                                echo     '<div class="img-delete"><i class="fa fa-times"></i></div>';
                                                echo '</a>';
                                            } else {
                                                echo '<input type="file" id="uploadImage" name="uploadImage" class="form-control-file">';
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="introduction" class="form-control-label">Chapô</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <textarea name="introduction" id="introduction" rows="9" placeholder="Chapô..." class="form-control"><?= $data['post']['introduction'] ?? '' ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="content" class="form-control-label">Contenu <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <textarea name="content" id="content" rows="15" placeholder="Contenu..." class="form-control"><?= $data['post']['content'] ?? '' ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-dot-circle-o"></i> Valider
                                    </button>
                                    <button type="reset" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> Réinitialiser
                                    </button>
                                    <a href="/admin/liste-des-articles/" class="btn btn-secondary btn-sm">
                                        <i class="fa fa-arrow-left"></i> Retour au sommaire
                                    </a>
                                </div>
                            </form>

                        </div>
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