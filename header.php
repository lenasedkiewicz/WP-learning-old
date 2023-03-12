<!DOCTYPE html>
<html>
<head>
    <?php wp_head(); ?>
</head>
<body>
<header class="site-header">
    <div class="container">
        <h1 class="school-logo-text float-left">
            <a href="<?php echo site_url() ?>"><strong>Jeden</strong> krok</a>
        </h1>
        <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
            <nav class="main-navigation">
                <ul>
                    <li><a href="<?php echo site_url('/about-us') ?>">O mnie</a></li>
                    <li><a href="#">Narzędzia</a></li>
                    <li><a href="#">Wydarzenia</a></li>
                    <li><a href="#">Mroczne Krainy</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </nav>
            <div class="site-header__util">
                <a href="#" class="btn btn--small btn--orange float-left push-right">Logowanie</a>
                <a href="#" class="btn btn--small btn--dark-orange float-left">Rejestracja</a>
                <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>
</header>