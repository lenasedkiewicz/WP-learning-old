<?php
// Load WordPress
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

if (isset($_POST['post_id']) && isset($_POST['associated_post_ids']) && isset($_POST['associated_category'])) {
    $post_id = absint($_POST['post_id']);
    $associated_post_ids = $_POST['associated_post_ids'];
    $associated_category = absint($_POST['associated_category']);

    update_post_meta($post_id, 'associated_post_ids', $associated_post_ids);
    update_post_meta($post_id, 'associated_category', $associated_category);
}
