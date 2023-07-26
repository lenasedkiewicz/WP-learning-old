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

// Add meta box for associating posts/pages with Javascript Tags
function javascript_tags_associate_meta_box() {
    add_meta_box(
        'javascript_tags_associate_meta_box',
        'Associate with Posts/Pages',
        'render_javascript_tags_associate_meta_box',
        'javascript_tags',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'javascript_tags_associate_meta_box');

function render_javascript_tags_associate_meta_box($post) {
    $associated_post_id = get_post_meta($post->ID, 'associated_post_id', true);
    $options = '<option value="0">Not Associated</option>';

    // Get all posts and pages as options for association
    $all_posts = get_posts(array(
        'post_type' => array('post', 'page'),
        'numberposts' => -1,
    ));

    foreach ($all_posts as $post_item) {
        $selected = ($associated_post_id == $post_item->ID) ? 'selected' : '';
        $options .= '<option value="' . esc_attr($post_item->ID) . '" ' . $selected . '>' . esc_html($post_item->post_title) . '</option>';
    }

    // Display the select dropdown
    echo '<label for="associated_post_id">Select Post/Page to Associate:</label>';
    echo '<select name="associated_post_id" id="associated_post_id">';
    echo $options;
    echo '</select>';
    wp_nonce_field('save_associated_post', 'associated_post_nonce');
}

// Save the associated items when the Javascript Tag is saved or updated
function save_javascript_tags_associated_items($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!isset($_POST['associated_post_nonce']) || !wp_verify_nonce($_POST['associated_post_nonce'], 'save_associated_post')) {
        return;
    }

    if (isset($_POST['associated_items'])) {
        $associated_items = $_POST['associated_items'];
        wp_set_post_terms($post_id, $associated_items, 'associated_items');
    } else {
        wp_remove_object_terms($post_id, '', 'associated_items');
    }
}
add_action('save_post', 'save_javascript_tags_associated_items');

// Output the JavaScript code in the footer for corresponding posts/pages
// Output the JavaScript code in the footer for corresponding posts/pages
function output_associated_javascript_in_footer() {
    if (!is_singular()) {
        return;
    }

    $post = get_post();
    $associated_items = get_the_terms($post->ID, 'associated_items');

    // Debug: Check if associated items are retrieved correctly
    if ($associated_items) {
        echo '<pre>';
        print_r($associated_items);
        echo '</pre>';
    }

    if (!empty($associated_items)) {
        foreach ($associated_items as $associated_item) {
            $associated_post_id = $associated_item->object_id;
            $javascript_code = get_post_meta($associated_post_id, 'javascript_code', true);

            // Debug: Check if JavaScript code is retrieved correctly
            if (!empty($javascript_code)) {
                echo '<pre>';
                echo 'Post ID: ' . $associated_post_id;
                echo '</pre>';
                echo '<script type="text/javascript">';
                echo $javascript_code;
                echo '</script>';
            }
        }
    }
}
add_action('wp_footer', 'output_associated_javascript_in_footer');

