<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php wp_head(); ?>
</head>

<body class="page-maintenance">

    <img src="<?= get_template_directory_uri() . '/assets/img/logo.png'; ?>" alt="<?= get_bloginfo('name') ?>">
    <p><?= get_bloginfo('description') ?></p>
    <h1>Under maintenance</h1>
    <p><b>We'll be back soon!</b></p>

    <?php wp_footer(); ?>
</body>
</html>