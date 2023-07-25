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
    render_javascript_tags_associate_meta_box($post, 'post', true, true, true);
}

function render_javascript_tags_associate_pages_meta_box($post) {
    render_javascript_tags_associate_meta_box($post, 'page', true, true, false);
}

function render_javascript_tags_associate_meta_box($post, $post_type = 'post', $show_all_option = false, $allow_multiple = false, $allow_category = false) {
    $associated_post_ids = get_post_meta($post->ID, 'associated_post_ids', true);
    if (!is_array($associated_post_ids)) {
        $associated_post_ids = array();
    }

    $options = '<option value="0">Not Associated</option>';

    if ($show_all_option) {
        $selected_all = (in_array('all', $associated_post_ids)) ? 'selected' : '';
        $options .= '<option value="all" ' . $selected_all . '>All ' . esc_html(ucfirst($post_type)) . '</option>';
    }

    // Get all posts or pages as options for association
    $all_items = get_posts(array(
        'post_type' => $post_type,
        'numberposts' => -1,
    ));

    foreach ($all_items as $post_item) {
        $selected = (in_array($post_item->ID, $associated_post_ids)) ? 'selected' : '';
        $options .= '<option value="' . esc_attr($post_item->ID) . '" ' . $selected . '>' . esc_html($post_item->post_title) . '</option>';
    }

    // Display the select dropdown
    echo '<label for="associated_post_ids">Select ' . esc_html(ucfirst($post_type)) . ' to Associate:</label>';
    echo '<select name="associated_post_ids[]" id="associated_post_ids" ' . (($allow_multiple) ? 'multiple' : '') . '>';
    echo $options;
    echo '</select>';

    // Add the category selection dropdown for posts
    if ($post_type === 'post' && $allow_category) {
        $associated_category = get_post_meta($post->ID, 'associated_category', true);
        $categories = get_categories(array('hide_empty' => false));

        $category_options = '<option value="0">Select Category</option>';
        foreach ($categories as $category) {
            $selected = ($associated_category === $category->term_id) ? 'selected' : '';
            $category_options .= '<option value="' . esc_attr($category->term_id) . '" ' . $selected . '>' . esc_html($category->name) . '</option>';
        }

        echo '<label for="associated_category">Select Category:</label>';
        echo '<select name="associated_category" id="associated_category">';
        echo $category_options;
        echo '</select>';
    }

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

    if (isset($_POST['associated_post_ids'])) {
        $associated_post_ids = array_map('absint', $_POST['associated_post_ids']);

        // Handle "All Posts" and "All Pages" options
        if (in_array('all', $associated_post_ids)) {
            $associated_post_ids = array('all');
        }

        update_post_meta($post_id, 'associated_post_ids', $associated_post_ids);
    } else {
        delete_post_meta($post_id, 'associated_post_ids');
    }

    if (isset($_POST['associated_category']) && $_POST['post_type'] === 'post') {
        $associated_category = absint($_POST['associated_category']);
        update_post_meta($post_id, 'associated_category', $associated_category);
    } else {
        delete_post_meta($post_id, 'associated_category');
    }
}
add_action('save_post', 'save_javascript_tags_associate_meta_box');
