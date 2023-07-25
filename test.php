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

// Add meta box for associating posts with Javascript Tags
function javascript_tags_associate_posts_meta_box() {
    add_meta_box(
        'javascript_tags_associate_posts_meta_box',
        'Associate with Posts',
        'render_javascript_tags_associate_posts_meta_box',
        'javascript_tags',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'javascript_tags_associate_posts_meta_box');

// Add meta box for associating pages with Javascript Tags
function javascript_tags_associate_pages_meta_box() {
    add_meta_box(
        'javascript_tags_associate_pages_meta_box',
        'Associate with Pages',
        'render_javascript_tags_associate_pages_meta_box',
        'javascript_tags',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'javascript_tags_associate_pages_meta_box');

// Render separate meta boxes with the dropdowns for posts and pages
function render_javascript_tags_associate_posts_meta_box($post) {
    render_javascript_tags_associate_meta_box($post, 'post');
}

function render_javascript_tags_associate_pages_meta_box($post) {
    render_javascript_tags_associate_meta_box($post, 'page');
}

function render_javascript_tags_associate_meta_box($post, $post_type = 'post') {
    $associated_post_id = get_post_meta($post->ID, 'associated_post_id', true);
    $options = '<option value="0">Not Associated</option>';

    // Get all posts or pages as options for association
    $all_items = get_posts(array(
        'post_type' => $post_type,
        'numberposts' => -1,
    ));

    foreach ($all_items as $post_item) {
        $selected = ($associated_post_id == $post_item->ID) ? 'selected' : '';
        $options .= '<option value="' . esc_attr($post_item->ID) . '" ' . $selected . '>' . esc_html($post_item->post_title) . '</option>';
    }

    // Display the select dropdown
    echo '<label for="associated_post_id">Select ' . esc_html(ucfirst($post_type)) . ' to Associate:</label>';
    echo '<select name="associated_post_id" id="associated_post_id">';
    echo $options;
    echo '</select>';
    wp_nonce_field('save_associated_post', 'associated_post_nonce');
}

// Save the associated post/page in the "Javascript Tags":

function save_javascript_tags_associate_meta_box($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!isset($_POST['associated_post_nonce']) || !wp_verify_nonce($_POST['associated_post_nonce'], 'save_associated_post')) {
        return;
    }

    if (isset($_POST['associated_post_id'])) {
        $associated_post_id = absint($_POST['associated_post_id']);
        update_post_meta($post_id, 'associated_post_id', $associated_post_id);
    } else {
        delete_post_meta($post_id, 'associated_post_id');
    }
}
add_action('save_post', 'save_javascript_tags_associate_meta_box');
