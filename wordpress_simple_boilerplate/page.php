<?php

get_header();

while(have_posts()) {
    the_post();
    pageBanner(); ?>

    <div class="">
        <div class="">
            <?php the_content(); ?>
        </div>

    </div>

<?php }

get_footer();

?>