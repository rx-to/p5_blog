<div class="section__content section__content--p30">
    <div class="container-fluid">
        <h3 class="title-5 m-b-35">Contenu de la demande de contact n°<?= $data[0]['id'] ?></h3>
        <p><strong>Le :</strong> <?= $data[0]['date'] ?></p>
        <p><strong>De :</strong> <?= "{$data[0]['first_name']} {$data[0]['last_name']} &lt;{$data[0]['email']}&gt;" ?></p>
        <p><strong>Objet :</strong> <?= $data[0]['subject'] ?></p>
        <p><strong>Message :</strong> <?= $data[0]['message'] ?></p>
        <a href="/admin/liste-des-contacts/" class="au-btn au-btn-icon au-btn--green au-btn--small mt-4"><i class="zmdi zmdi-arrow-left"></i>Retour au sommaire</a>
    </div>
</div>