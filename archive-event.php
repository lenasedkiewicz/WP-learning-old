<?php
get_header();

pageBanner(array(
    'title' => 'Wydarzenia',
    'subtitle' => 'Wydarzenia, w których warto wziąć udział!'
));
?>
    <div class="container container--narrow page-section">
        <?php
        while(have_posts()) {
            the_post(); ?>
            <div class="event-summary">
                <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                        <span class="event-summary__month"><?php
                            $eventDate = new DateTime(get_field('event_date'));
                            echo $eventDate->format('M')
                            ?></span>
                    <span class="event-summary__day"><?php
                        $eventDate = new DateTime(get_field('event_date'));
                        echo $eventDate->format('d')
                        ?></span>
                </a>
                <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    <p><?php echo wp_trim_words(get_the_content(), 15); ?> <a href="<?php the_permalink(); ?>" class="nu gray">Więcej</a></p>
                </div>
            </div>
            <?php
        }
        echo paginate_links();
        ?>
        <hr class="section-break">
        <p>Chcesz zobaczyć minione wydarzenia? Zajrzyj do <a href="<?php echo site_url('/archiwum-wydarzen/') ?>">archiwum wydarzeń</a>!</p>

    </div>
<?php
get_footer();
?>