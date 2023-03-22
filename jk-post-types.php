<?php

/* Register post types */

function jk_post_types(){

    // Wydarzenia

    register_post_type('event', array(
        'supports' => array('title', 'editor', 'excerpt', ),
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

    //Warsztaty

    register_post_type('workshop', array(
        'supports' => array('title', 'editor', 'excerpt', ),
        'rewrite' => array(
            'slug' => 'warsztaty',
        ),
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Warsztaty',
            'add_new_item' => 'Dodaj warsztaty',
            'edit_item' => 'Edytuj warsztaty',
            'all_items' => 'Lista warsztatów',
            'singular_name' => 'Warsztaty',
        ),
        'menu_icon' => 'dashicons-edit',
    ));

    // Autorzy

    register_post_type('blogauthor', array(
        'supports' => array('title', 'editor', 'excerpt', ),
        'rewrite' => array(
            'slug' => 'autor',
        ),
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Autorzy',
            'add_new_item' => 'Dodaj autora',
            'edit_item' => 'Edytuj autora',
            'all_items' => 'Lista autorów',
            'singular_name' => 'Autorzy',
        ),
        'menu_icon' => 'dashicons-businessperson',
    ));
};

add_action('init', 'jk_post_types');

?>