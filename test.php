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

    $options = '';

    if ($show_all_option) {
        $selected_all = (in_array('all', $associated_post_ids)) ? 'checked' : '';
        $options .= '<input type="checkbox" name="associated_post_ids[]" id="associated_post_ids_all" value="all" ' . $selected_all . '>';
        $options .= '<label for="associated_post_ids_all">All ' . esc_html(ucfirst($post_type)) . '</label><br>';
    }

    // Get all posts or pages as options for association
    $all_items = get_posts(array(
        'post_type' => $post_type,
        'numberposts' => -1,
    ));

    foreach ($all_items as $post_item) {
        $checked = (in_array($post_item->ID, $associated_post_ids)) ? 'checked' : '';
        $options .= '<input type="checkbox" name="associated_post_ids[]" id="associated_post_id_' . $post_item->ID . '" value="' . esc_attr($post_item->ID) . '" ' . $checked . '>';
        $options .= '<label for="associated_post_id_' . $post_item->ID . '">' . esc_html($post_item->post_title) . '</label><br>';
    }

    // Display the checkboxes
    echo '<p>Associate with ' . esc_html(ucfirst($post_type)) . ':</p>';
    echo $options;

    // Add the category selection dropdown for posts
    if ($post_type === 'post' && $allow_category) {
        $associated_category = get_post_meta($post->ID, 'associated_category', true);
        $categories = get_categories(array('hide_empty' => false));

        $category_options = '<option value="0">Select Category</option>';
        foreach ($categories as $category) {
            $selected = ($associated_category == $category->term_id) ? 'selected' : '';
            $category_options .= '<option value="' . esc_attr($category->term_id) . '" ' . $selected . '>' . esc_html($category->name) . '</option>';
        }

        echo '<p>Select Category:</p>';
        echo '<select name="associated_category" id="associated_category">';
        echo $category_options;
        echo '</select>';
    }

    wp_nonce_field('save_associated_post', 'associated_post_nonce');

    // Enqueue JavaScript for handling checkboxes and category selection
    echo '<script src="' . plugin_dir_url(__FILE__) . 'js/associate-script.js"></script>';
}

// Save the associated post/page in the "Javascript Tags":

function save_javascript_tags_associate_meta_box($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!isset($_POST['associated_post_nonce']) || !wp_verify_nonce($_POST['associated_post_nonce'], 'save_associated_post')) {
        return;
    }

    // Handle "All Posts" option
    if (isset($_POST['associated_post_ids']) && in_array('all', $_POST['associated_post_ids'])) {
        update_post_meta($post_id, 'associated_post_ids', array('all'));
        delete_post_meta($post_id, 'javascript_code'); // Remove any previously saved JavaScript code
    } elseif (isset($_POST['associated_post_ids'])) {
        $associated_post_ids = array_map('absint', $_POST['associated_post_ids']);
        update_post_meta($post_id, 'associated_post_ids', $associated_post_ids);
        delete_post_meta($post_id, 'javascript_code'); // Remove any previously saved JavaScript code
    } else {
        delete_post_meta($post_id, 'associated_post_ids');
        delete_post_meta($post_id, 'javascript_code'); // Remove any previously saved JavaScript code
    }

    // Handle category selection for posts
    if (isset($_POST['associated_category']) && $_POST['post_type'] === 'post') {
        $associated_category = absint($_POST['associated_category']);
        update_post_meta($post_id, 'associated_category', $associated_category);
        delete_post_meta($post_id, 'javascript_code'); // Remove any previously saved JavaScript code
    } else {
        delete_post_meta($post_id, 'associated_category');
    }

    // Save the JavaScript code associated with the post
    if (isset($_POST['javascript_code'])) {
        update_post_meta($post_id, 'javascript_code', sanitize_textarea_field($_POST['javascript_code']));
    }
}
add_action('save_post', 'save_javascript_tags_associate_meta_box');


//Add function

function get_associated_posts_pages_and_category($post_id) {
    $associated_post_ids = get_post_meta($post_id, 'associated_post_ids', true);
    $associated_category = get_post_meta($post_id, 'associated_category', true);

    $associated_posts_pages = array();

    if (is_array($associated_post_ids) && !empty($associated_post_ids)) {
        if (in_array('all', $associated_post_ids)) {
            $associated_posts_pages[] = 'All Posts/Pages';
        } else {
            foreach ($associated_post_ids as $post_id) {
                $post = get_post($post_id);
                if ($post) {
                    $associated_posts_pages[] = $post->post_title;
                }
            }
        }
    }

    if ($associated_category) {
        $category = get_category($associated_category);
        if ($category) {
            $associated_posts_pages[] = 'Category: ' . $category->name;
        }
    }

    return $associated_posts_pages;
}



// Add a custom column to the "Javascript Tags" admin page to display the associations

function add_associations_column_to_javascript_tags($columns) {
    $columns['associated_items'] = 'Associated Items';
    return $columns;
}
add_filter('manage_javascript_tags_posts_columns', 'add_associations_column_to_javascript_tags');

function render_associations_column_to_javascript_tags($column, $post_id) {
    if ($column === 'associated_items') {
        $associated_posts_pages = get_associated_posts_pages_and_category($post_id);

        if (!empty($associated_posts_pages)) {
            echo '<ul>';
            foreach ($associated_posts_pages as $item) {
                echo '<li>' . esc_html($item) . '</li>';
            }
            echo '</ul>';
        }
    }
}
add_action('manage_javascript_tags_posts_custom_column', 'render_associations_column_to_javascript_tags', 10, 2);


// Output the JavaScript code in the footer for corresponding posts/pages
function output_associated_javascript_in_footer() {
    if (!is_singular()) {
        return;
    }

    $post = get_post();
    $associated_post_ids = get_post_meta($post->ID, 'associated_post_ids', true);

    if (!empty($associated_post_ids)) {
        foreach ($associated_post_ids as $associated_post_id) {
            $associated_post = get_post($associated_post_id);
            if ($associated_post) {
                $javascript_code = get_post_meta($associated_post->ID, 'javascript_code', true);
                if (!empty($javascript_code)) {
                    echo '<script type="text/javascript">';
                    echo $javascript_code;
                    echo '</script>';
                }
            }
        }
    }
}
add_action('wp_footer', 'output_associated_javascript_in_footer');

function display_associated_javascript_in_footer() {
    global $post;

    if (!is_singular('post') && !is_singular('page')) {
        return; // Display the JavaScript code only on single posts and pages
    }

    $post_id = $post->ID;
    $associated_tags = get_post_meta($post_id, 'associated_post_ids', true);
    $associated_category = get_post_meta($post_id, 'associated_category', true);

    // Check if the current post/page is associated with a Javascript Tag
    if (!empty($associated_tags) || !empty($associated_category)) {
        $args = array(
            'post_type' => 'javascript_tags',
            'posts_per_page' => -1,
            'post__in' => $associated_tags,
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $associated_category,
                ),
            ),
        );

        $query = new WP_Query($args);

        // Loop through the associated Javascript Tags and display their code in the footer
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $javascript_code = get_the_content();
                if (!empty($javascript_code)) {
                    echo '<script type="text/javascript">';
                    echo $javascript_code;
                    echo '</script>';
                }
            }
            wp_reset_postdata();
        }
    }
}
add_action('wp_footer', 'display_associated_javascript_in_footer');
