<?php
/*
Plugin Name: Your JavaScript Tags Plugin
Description: A custom plugin for adding a custom post type named "Javascript Tags."
Version: 1.0
Author: Your Name
*/

// Register the custom post type
function custom_post_type() {
    $labels = array(
        'name'               => 'Javascript Tags',
        'singular_name'      => 'Javascript Tag',
        'menu_name'          => 'Javascript Tags',
        'name_admin_bar'     => 'Javascript Tag',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Javascript Tag',
        'new_item'           => 'New Javascript Tag',
        'edit_item'          => 'Edit Javascript Tag',
        'view_item'          => 'View Javascript Tag',
        'all_items'          => 'All Javascript Tags',
        'search_items'       => 'Search Javascript Tags',
        'parent_item_colon'  => 'Parent Javascript Tags:',
        'not_found'          => 'No Javascript tags found.',
        'not_found_in_trash' => 'No Javascript tags found in Trash.',
        'post_type' => 'javascript_tags',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'javascript_tags'),
        'capability_type'    => 'javascript_tag', // Set custom capability type
        'map_meta_cap'       => true, // Enable custom capabilities
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor'),
    );

    register_post_type('javascript_tags', $args);
}
add_action('init', 'custom_post_type');

// Register custom taxonomy for associating "Javascript Tags" with other posts/pages
function register_associated_items_taxonomy() {
    $labels = array(
        'name'              => 'Associated Items',
        'singular_name'     => 'Associated Item',
        'search_items'      => 'Search Associated Items',
        'all_items'         => 'All Associated Items',
        'edit_item'         => 'Edit Associated Item',
        'update_item'       => 'Update Associated Item',
        'add_new_item'      => 'Add New Associated Item',
        'new_item_name'     => 'New Associated Item Name',
        'menu_name'         => 'Associated Items',
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'associated-items'),
    );

    register_taxonomy('associated_items', 'javascript_tags', $args);
}
add_action('init', 'register_associated_items_taxonomy');


// Set up user capabilities
function add_javascript_tags_caps() {
    $roles = array('administrator', 'editor'); // Add any other custom roles if necessary

    foreach ($roles as $role_name) {
        $role = get_role($role_name);
        $role->add_cap('edit_javascript_tags');
        $role->add_cap('edit_other_javascript_tags');
        $role->add_cap('publish_javascript_tags');
        $role->add_cap('read_private_javascript_tags');
        $role->add_cap('delete_javascript_tags');
        $role->add_cap('read_javascript_tags'); // Add the 'read_javascript_tags' capability
    }
}
register_activation_hook(__FILE__, 'add_javascript_tags_caps');

// Function to check if the current post and JavaScript Tag have the same tag
function display_associated_javascript_tag_content() {
    // Check if we are on a single post/page and if the queried object is valid
    if (is_singular() && is_main_query() && function_exists('get_queried_object')) {
        $queried_object = get_queried_object();

        if ($queried_object instanceof WP_Post) {
            $post = $queried_object;


        // Get the associated items (tags) of the current post/page
        $associated_items = wp_get_post_terms($post->ID);
        if ($associated_items) {
            $associated_items = wp_get_post_terms($post->ID)[0]->name;
        }
        // Check if there are associated items
        // print_r(wp_get_post_terms($post->ID)[0]->name);
        // echo $associated_items;

        if (!empty($associated_items)) {
            $args = array(
                'tax_query' => array(
                    array(
                        'terms' => $associated_items,
                    ),
                ),
            );
            // echo $args['tax_query'][0]['terms'];

            // Query the JavaScript Tag custom post type with the associated items
            $query = new WP_Query($associated_items);

            // Check if there are matching JavaScript Tags
            $searchforposts = $query->have_posts();
            $slug= get_the_tags($searchforposts)[0]->slug;
            if ($query->have_posts()) {
                wp_reset_postdata(); // Reset the query to prevent conflicts
                // var_dump(get_post_types());
                $taxonomy = get_terms('my_custom_taxonomy');
                $term = $taxonomy[0]->name;
                $jtag = array(
                    'post_type' => 'javascript_tags',
                    'post_status' => 'publish',
                );
                // var_dump(get_terms());
                $loop = new WP_Query( $jtag );
                // echo get_posts($searchforposts);
                //ob_start(); // Start the buffer to capture the output
                // var_dump($loop);
                    while ( $loop->have_posts() ) : $loop->the_post();
                    your_plugin_inject_script();
                    endwhile;
                    wp_reset_postdata();

                //return ob_get_clean(); // Return the captured content from the buffer
            }
        }
    }
}
}

add_action('wp', 'display_associated_javascript_tag_content');


// Register custom taxonomy for associating with "Javascript Tags" custom post type
function register_my_custom_taxonomy() {
    $labels = array(
        'name'              => 'My Custom Taxonomy',
        'singular_name'     => 'My Custom Taxonomy',
        'search_items'      => 'Search My Custom Taxonomy',
        'all_items'         => 'All My Custom Taxonomy',
        'edit_item'         => 'Edit My Custom Taxonomy',
        'update_item'       => 'Update My Custom Taxonomy',
        'add_new_item'      => 'Add New My Custom Taxonomy',
        'new_item_name'     => 'New My Custom Taxonomy Name',
        'menu_name'         => 'My Custom Taxonomy',
    );

    $args = array(
        'hierarchical'      => true, // Set this to false for non-hierarchical (tags-like) taxonomy
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        // Replace 'javascript_tags' with the custom post type you want to associate with
        'object_type'       => array('javascript_tags'),
        // Other taxonomy arguments you may want to add
        // 'rewrite'         => array('slug' => 'js-tags'),
    );

    register_taxonomy('my_custom_taxonomy', 'javascript_tags', $args);
}
add_action('init', 'register_my_custom_taxonomy');

function your_plugin_inject_script() {
    echo '<script type="text/javascript">' . PHP_EOL;
    echo get_the_content();
    echo '</script>' . PHP_EOL;
}
add_action('wp_footer', 'your_plugin_inject_script');