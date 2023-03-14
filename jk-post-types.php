<?php

/* Register post types */

function jk_post_types(){
    register_post_type('event', array(
        'public' => true,
        'labels' => array(
            'name' => 'Wydarzenia',
        ),
        'menu_icon' => 'dashicons-calendar',
    ));
};

add_action('init', 'jk_post_types');

?>