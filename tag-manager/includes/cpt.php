<?php

// Register custom post types
function tm_custom_post_type() {
    $labels = array(
        'name' => 'Tagi',
        'singular_name' => 'Tag',
        'menu_name' => 'Tagi',
        // Add more labels as needed
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'show_in_admin_bar' => true
        // Add more arguments as needed
    );

    register_post_type('your_tag_post', $args);
}
// Register the custom post type
add_action('init', 'tm_custom_post_type');