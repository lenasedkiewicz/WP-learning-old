<?php

/* Register post types */

function jk_post_types(){
    register_post_type('event', array(
        'supports' => array('title', 'editor', 'excerpt', 'custom-fields', ),
        'rewrite' => array(
            'slug' => 'wydarzenia',
        ),
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Wydarzenia',
            'add_new_item' => 'Dodaj wydarzenie',
            'edit_item' => 'Edytuj wydarzenie',
            'all_items' => 'Lista wydarzeń',
            'singular_name' => 'Wydarzenie',
        ),
        'menu_icon' => 'dashicons-calendar',
    ));
};

add_action('init', 'jk_post_types');

?>