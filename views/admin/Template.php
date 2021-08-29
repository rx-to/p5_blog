<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
    echo isset($data['page']['meta_description']) ? '<meta name="description" content="' . $data['page']['meta_description'] . '">' : '';
    echo isset($data['page']['meta_keywords'])    ? '<meta name="keywords" content="' . $data['page']['meta_keywords'] . '">'       : '';
    echo '<title>' . $data['page']['meta_title'] . '</title>';
    ?>
    <!-- Fontfaces CSS-->
    <link href="/assets/themes/cool-admin/css/font-face.css" rel="stylesheet" media="all">
    <link href="/assets/themes/cool-admin/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="/assets/themes/cool-admin/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="/assets/themes/cool-admin/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="/assets/themes/cool-admin/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="/assets/themes/cool-admin/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="/assets/themes/cool-admin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="/assets/themes/cool-admin/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="/assets/themes/cool-admin/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="/assets/themes/cool-admin/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="/assets/themes/cool-admin/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="/assets/themes/cool-admin/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="/assets/themes/cool-admin/css/theme.css" rel="stylesheet" media="all">
    <link href="/assets/themes/cool-admin/css/custom.css" rel="stylesheet" media="all">
</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="/">
                            <img src="/assets/themes/cool-admin/img/logo.jpg" class="logo-efblog" alt="CoolAdmin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub<?= in_array($slug, ['liste-des-articles', 'detail-article', 'editer-un-article']) ? ' active' : '' ?>">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-file"></i>Articles</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/admin/liste-des-articles/" <?= $slug == 'liste-des-articles' ? 'class="font-weight-bold"' : '' ?>>Tous les articles</a>
                                </li>
                                <li>
                                    <a href="/admin/creer-un-article/" <?= $slug == 'detail-article' ? 'class="font-weight-bold"' : '' ?>>Créer un article</a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub<?= in_array($slug, ['liste-des-commentaires', 'commentaires-en-attente, detail-commentaire']) ? ' active' : '' ?>">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-comment"></i>Commentaires</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/admin/liste-des-commentaires/">Tous les commentaires</a>
                                </li>
                                <li>
                                    <a href="/admin/commentaires-en-attente/">Commentaires en attente</a>
                                </li>
                            </ul>
                        </li>
                        <li <?= in_array($slug, ['liste-des-contacts', 'contact']) ? ' class="active"' : '' ?>>
                            <a href="/admin/liste-des-contacts/">
                                <i class="fas fa-user"></i>Liste des contacts</a>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="/">
                    <img src="/assets/themes/cool-admin/img/logo.jpg" class="logo-efblog" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <!-- <li class="active has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/">Dashboard 1</a>
                                </li>
                                <li>
                                    <a href="index2.html">Dashboard 2</a>
                                </li>
                                <li>
                                    <a href="index3.html">Dashboard 3</a>
                                </li>
                                <li>
                                    <a href="index4.html">Dashboard 4</a>
                                </li>
                            </ul>
                        </li> -->
                        <li class="has-sub<?= in_array($slug, ['liste-des-articles', 'detail-article', 'editer-un-article']) ? ' active' : '' ?>">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-file"></i>Articles</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/admin/liste-des-articles/" <?= $slug == 'liste-des-articles' ? 'class="font-weight-bold"' : '' ?>>Tous les articles</a>
                                </li>
                                <li>
                                    <a href="/admin/creer-un-article/" <?= $slug == 'detail-article' ? 'class="font-weight-bold"' : '' ?>>Créer un article</a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub<?= in_array($slug, ['liste-des-commentaires', 'commentaires-en-attente', 'detail-commentaire']) ? ' active' : '' ?>">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-comment"></i>Commentaires</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/admin/liste-des-commentaires/">Tous les commentaires</a>
                                </li>
                                <li>
                                    <a href="/admin/commentaires-en-attente/">Commentaires en attente</a>
                                </li>
                            </ul>
                        </li>
                        <li <?= in_array($slug, ['liste-des-contacts', 'contact']) ? ' class="active"' : '' ?>>
                            <a href="/admin/liste-des-contacts/">
                                <i class="fas fa-user"></i>Liste des contacts</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid text-right">
                        <div class="header-wrap d-inline-block">
                            <div class="header-button mt-0">
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            <img src="/upload/avatar/<?= $curUser['avatar'] ?>" alt="<?= "{$curUser['first_name']} {$curUser['last_name']}" ?>" />
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="#"><?= "{$curUser['first_name']} {$curUser['last_name']}" ?></a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
                                                        <img src="/upload/avatar/<?= $curUser['avatar'] ?>" alt="<?= "{$curUser['first_name']} {$curUser['last_name']}" ?>" />
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#"><?= "{$curUser['first_name']} {$curUser['last_name']}" ?></a>
                                                    </h5>
                                                    <span class="email"><?= $curUser['email'] ?></span>
                                                </div>
                                            </div>
                                            <!-- <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="#"><i class="zmdi zmdi-account"></i>Compte</a>
                                                </div>
                                            </div> -->
                                            <div class="account-dropdown__footer">
                                                <a href="/deconnexion/"><i class="zmdi zmdi-power"></i>Déconnexion</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <?= $content ?>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="/assets/themes/cool-admin/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="/assets/themes/cool-admin/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="/assets/themes/cool-admin/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="/assets/themes/cool-admin/vendor/slick/slick.min.js">
    </script>
    <script src="/assets/themes/cool-admin/vendor/wow/wow.min.js"></script>
    <script src="/assets/themes/cool-admin/vendor/animsition/animsition.min.js"></script>
    <script src="/assets/themes/cool-admin/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="/assets/themes/cool-admin/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="/assets/themes/cool-admin/vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="/assets/themes/cool-admin/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="/assets/themes/cool-admin/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/assets/themes/cool-admin/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="/assets/themes/cool-admin/vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="/assets/themes/cool-admin/js/main.js"></script>
    <script src="/assets/themes/cool-admin/js/custom.js"></script>
    <script src="https://cdn.tiny.cloud/1/i6qvw9jnrrrclkm5lgxqbhpoanylmmqkc5pwufyo7eji4bce/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
        });
    </script>

</body>

</html>
<!-- end document-->