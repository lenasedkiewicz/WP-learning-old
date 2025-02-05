<?php

/* Template name: Blog page Template */

get_header();
pageBanner(array(
    'title' => 'Blog',
    'subtitle' => 'Najnowsze wpisy'
));
?>

<div class="">
    <div class="">
    <?php
    while(have_posts()) {
    the_post(); ?>
        <div class="">
            <h2 class=""><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="">
                <?php the_post_thumbnail( 'medium' );  ?>
            </div>
            <div>
                <?php the_excerpt(); ?>
                <p><a class="button" href="<?php the_permalink(); ?>">Więcej &raquo</a></p>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<div class="">
    <?php  echo paginate_links(); ?>
</div>
<?php
    get_footer();
?>