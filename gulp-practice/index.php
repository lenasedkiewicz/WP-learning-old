<?php get_header();

if(have_posts()) {
    while(have_posts()) {
        the_post(); ?>
        <h2>
            <a href="<?php echo the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
        </h2>
        <div>
            <?php gulpwp_meta_description(); ?>
        </div>
        <div>
            <?php the_excerpt(); ?>
        </div>
        <?php gulpwp_readmore(); ?>
    <?php }
    the_posts_pagination();
 } else { ?>
    <p><?php echo esc_html_e('Sorry, no posts matched your criteria.', 'gulppracticeone') ?></p>
<?php }

get_footer(); ?>