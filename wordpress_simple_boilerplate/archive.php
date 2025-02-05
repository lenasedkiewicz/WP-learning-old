<?php
get_header();

pageBanner(array(
   'title' => get_the_archive_title(),
   'subtitle' => get_the_archive_description()
));
?>

    <div class="">
        <?php
        while(have_posts()) {
            the_post(); ?>
            <div class="">
                <h2 class=""><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="">
                    <p>Autor: <?php the_author_posts_link(); ?>, opublikowane: <?php the_time('l, j F Y'); ?>, kategoria: <?php echo get_the_category_list(', '); ?></p>
                </div>
                <div class="">
                    <?php the_excerpt(); ?>
                    <p><a class="" href="<?php the_permalink(); ?>">Więcej &raquo</a></p>
                </div>
            </div>
            <?php
        }
        echo paginate_links();
        ?>

    </div>
<?php
get_footer();
?>