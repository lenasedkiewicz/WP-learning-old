<?php
get_header();
pageBanner();

while(have_posts()) {
    the_post(); ?>

    <div class="">
        <div class="">
            <p><a class="" href="<?php echo site_url('...'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Blog</a> <span class=""><?php the_author_posts_link(); ?>, <?php the_time('j F Y'); ?>, <?php echo get_the_category_list(', '); ?></span></p>
        </div>
        <div>
            <?php the_post_thumbnail(); ?>
        </div>
        <div class=""><?php the_content(); ?></div>

    </div>
    <?php
}
get_footer();
?>