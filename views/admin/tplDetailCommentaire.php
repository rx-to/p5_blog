<div class="section__content section__content--p30">
    <div class="container-fluid">
        <h3 class="title-5 m-b-35">Contenu du commentaire n°<?= $data['comment']['id'] ?></h3>
        <p><strong>Le :</strong> <?= $data['comment']['update_date'] ?? $data['comment']['creation_date'] ?></p>
        <p><strong>De :</strong> <?= "{$data['comment']['author_first_name']} {$data['comment']['author_last_name']}" ?></p>
        <p><strong>Commentaire :</strong> <?= $data['comment']['content'] ?></p>
        <a href="/admin/liste-des-commentaires/" class="au-btn au-btn-icon au-btn--blue au-btn--small mt-4"><i class="zmdi zmdi-arrow-left"></i>Retour au sommaire</a>
    </div>
</div>
