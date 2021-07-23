<div class="section__content section__content--p30">
    <div class="container-fluid">
        <!-- DATA TABLE -->
        <h3 class="title-5 m-b-35">Liste des messages</h3>

        <div class="table-responsive table-responsive-data2">
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>E-mail</th>
                        <th>Objet</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data as $key => $contact) {
                        if (is_int($key)) {
                            echo '<tr class="tr-shadow">';
                            echo    '<td>' . $contact['date_fr'] . '</td>';
                            echo    '<td>' . $contact['last_name'] . '</td>';
                            echo    '<td>' . $contact['first_name'] . '</td>';
                            echo    '<td>';
                            echo        '<span class="block-email">' . $contact['email'] . '</span>';
                            echo    '</td>';
                            echo    '<td class="desc">' . $contact['subject'] . '</td>';
                            echo    '<td>';
                            echo        '<div class="table-data-feature">';
                            echo            '<a href="/admin/contact/' . $contact['id'] . '/" class="item" data-toggle="tooltip" data-placement="top" title="Consulter">';
                            echo                '<i class="fas fa-eye"></i>';
                            echo            '</a>';
                            echo        '</div>';
                            echo    '</td>';
                            echo '</tr>';
                        }
                    } ?>
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE -->
    </div>
</div>