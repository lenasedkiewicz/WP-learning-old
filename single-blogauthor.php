<?php
get_header();

while(have_posts()) {
    the_post();
    pageBanner(); ?>
    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="row group">
                <div class="one-third"><?php the_post_thumbnail('authorPortrait'); ?></div>
                <div class="two-thirds"><?php the_content(); ?></div>
            </div>
        </div>

        <?php
        $relatedWorkshops = get_field('related_workshops');

        if($relatedWorkshops) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Autor(ka) warsztatów:</h2>';
            echo '<ul class="link-list min-list">';
            foreach($relatedWorkshops as $workshop){
                ?>
                <li><a href="<?php echo get_the_permalink($workshop) ?>"><?php echo get_the_title($workshop); ?></a></li>
            <?php }
            echo "</ul>";
        }
        ?>
    </div>
    <?php
}
get_footer();
?>