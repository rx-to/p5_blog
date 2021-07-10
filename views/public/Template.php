<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    echo isset($data['page']['meta_description']) ? '<meta name="description" content="' . $data['page']['meta_description'] . '">' : '';
    echo isset($data['page']['meta_keywords'])    ? '<meta name="keywords" content="' . $data['page']['meta_keywords'] . '">'       : '';
    echo '<title>' . $data['page']['meta_title'] . '</title>';
    ?>
    <link href="/assets/themes/clean-blog/favicon.ico" rel="icon" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    </link>
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet">
    <link href="/assets/themes/clean-blog/css/style.css" rel="stylesheet">
    <link href="/assets/themes/clean-blog/css/custom.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="/">EF Blog</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item<?= in_array($slug, ['accueil']) ? ' active' : '' ?>"><a class="nav-link" href="/">Accueil</a></li>
                    <li class="nav-item<?= in_array($slug, ['articles', 'article']) ? ' active' : '' ?>"><a class="nav-link" href="/articles/">Articles</a></li>
                    <li class="nav-item<?= in_array($slug, ['contact']) ? ' active' : '' ?>"><a class="nav-link" href="/contact/">Contact</a></li>
                    <?php if (isset($curUser['id'])) { ?>
                        <?php if($controllerUser->isAdmin($curUser['id'])) { ?>
                            <li class="nav-item"><a class="nav-link" href="/admin/">Administration</a></li>
                        <?php } ?>
                        <li class="nav-item"><a class="nav-link" href="/deconnexion/">Déconnexion</a></li>
                    <?php } else { ?>
                        <li class="nav-item<?= in_array($slug, ['inscription', 'connexion']) ? ' active' : '' ?>"><a class="nav-link" href="/connexion/">Connexion</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <header class="masthead" style="background-image: url('/assets/themes/clean-blog/img/<?= $data['page']['header'] ?>')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-heading">
                        <h1><?= $data['page']['title'] ?></h1>
                        <?= $data['page']['subtitle'] ? '<span class="subheading">' . $data['page']['subtitle'] . '</span>' : '' ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <?= $content ?>
    </main>

    <hr>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <ul class="list-inline text-center">
                        <li class="list-inline-item">
                            <a href="#!">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <br>
                    <p class="copyright text-muted">Copyright © 2021 — EF Blog — <a href="/mentions-legales/">Mentions légales</a></p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/themes/clean-blog/js/scripts.js"></script>
    <script src="/assets/themes/clean-blog/js/custom.js"></script>
</body>

</html>