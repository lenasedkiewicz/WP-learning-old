<?php

function jk_files() {
    wp_enqueue_script('jk-main-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    wp_enqueue_style('font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css');
    wp_enqueue_style('jk_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('jk_additional_styles', get_theme_file_uri('/build/index.css'));
}
add_action('wp_enqueue_scripts', 'jk_files');

/* add features */

function jk_features() {
    /*add support for menus */
    register_nav_menu('headerMenu', 'Header Menu');
    register_nav_menu('footerMenuOne', 'Footer Menu 1');
    register_nav_menu('footerMenuTwo', 'Footer Menu 2');
    /* add support for blog posts images */
    add_theme_support( 'post-thumbnails' );
    add_theme_support('title-tag'); // add description in browser tab
}
add_action('after_setup_theme', 'jk_features');

/* Reusable function for page banner */
function pageBanner($args = NULL) {
    if (!isset($args['title'])) {
        $args['title'] = get_the_title();
    }
    ?>
    <div class="">
        <div class="">
            <h1 class=""><?php echo $args['title'] ?></h1>
        </div>
    </div>
<?php
}

// Add options checkbox to Settings / General 
function mythemename_settings_general_maintenance()
{
    add_settings_section(
        'my_settings_section', // Section ID 
        'ADDITIONAL SETTINGS', // Section Title
        'my_section_options_callback', // Content Callback
        'general' // Show under "General" settings page
    );
    add_settings_field(
        'maintenance_mode', // Option ID
        'Maintenance mode', // Option Label
        'maintenance_mode_callback', // Callback for Arguments 
        'general', // Show under "General" settings page
        'my_settings_section', // Name of the section
        array( // The $args to pass to the callback
            'maintenance_mode' // Should match Option ID
        )
    );
    register_setting('general', 'maintenance_mode', 'esc_attr');
}
function my_section_options_callback()
{
    // Custom Section Callback content
    echo "Custom theme options";
}
function maintenance_mode_callback($args)
{
    // Checkbox Callback
    $value = get_option($args[0]);
    $checked = ($value == "on") ? "checked" : "";
    echo "<label>
      <input type=\"checkbox\" id=\"$args[0]\" name=\"$args[0]\" $checked />
      <span>Check to activate Maintenance Mode page</span>
    </label><p>A general <i>Under Maintenance</i> page will be shown to non-admin users.</p>";
}
add_action('admin_init', 'mythemename_settings_general_maintenance');

// Handle Maintenance page
if (!function_exists('wp_under_maintenance')) :
    function wp_under_maintenance()
    {
        $isLoginPage = basename($_SERVER['PHP_SELF']) == 'wp-login.php';
        $isMaintenanceModeOn = get_option('maintenance_mode') == "on";

        if (
            $isMaintenanceModeOn &&
            !$isLoginPage &&
            !is_user_logged_in() &&
            !is_admin() &&
            !current_user_can("update_plugins")
        ) {
            get_template_part('maintenance');
            exit();
        }
    }
endif;
add_action('init', 'wp_under_maintenance', 30);