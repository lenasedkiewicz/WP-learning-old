<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
<header class="">
    <div class="">
        <h1 class="">
            <a href="<?php echo site_url() ?>"><!--add site name and desc rendering --></a>
        </h1>
        <span class=""><i class="fa fa-search" aria-hidden="true"></i></span>
        <i class="" aria-hidden="true"></i>
        <div class="">
            <nav class="">
            <?php wp_nav_menu(array(
                'theme_location' => 'headerMenu',
            )); ?>
            </nav>
            <div class="">
                <span class=""><i class="fa fa-search" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>
</header>