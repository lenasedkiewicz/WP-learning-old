<?php

// Add the admin settings page
add_action('admin_menu', 'tm_add_menu_item');
function tm_add_menu_item() {
    // Allow access only to administrators (use 'manage_options' capability)
    if (current_user_can('manage_options')) {
        add_menu_page(
            'Ustawienia - Marketing Tag Manager',
            'Marketing Tag Manager',
            'manage_options',
            'tm-settings',
            'tm_settings_page',
            'dashicons-editor-code'
        );
    }
}

// Render the settings page content (updated version)
function tm_settings_page() {
    // Allow access only to administrators (use 'manage_options' capability)
    if (!current_user_can('manage_options')) {
        echo '<div class="error"><p>Aby dodać tag, skontaktuj się z administratorem strony.</p></div>';
        return;
    }

    // Rest of the settings page code (unchanged)
    if (isset($_POST['your_plugin_script'])) {
        update_option('your_plugin_script', $_POST['your_plugin_script']);
        echo '<div class="notice notice-success"><p>Zmiany zostały zapisane!</p></div>';
    }

    // Display the settings form
    ?>
    <div class="wrap">
        <h1>Ustawienia</h1>
        <form method="post" action="">
            <?php
            // Output the WordPress nonce for security
            wp_nonce_field('your_plugin_settings_nonce', 'your_plugin_settings_nonce');
            ?>

            <label for="your_plugin_script">Dodaj skrypt:</label><br>
            <textarea name="your_plugin_script" id="your_plugin_script" rows="6" cols="60"><?php echo esc_textarea(get_option('your_plugin_script')); ?></textarea><br>

            <input type="submit" name="submit" value="Save Script" class="button-primary">
        </form>
    </div>
    <?php
}

// Define the shortcode to execute the script
add_shortcode('execute_script', 'your_plugin_execute_script_shortcode');
function your_plugin_execute_script_shortcode($atts, $content = null) {
    ob_start();
    eval('?>' . do_shortcode($content));
    return ob_get_clean();
}


// Add the admin settings page (same as before)

// Validate and sanitize the script content
function your_plugin_sanitize_script($script) {
    // Your validation rules here
    // For example, check if the script contains only specific JavaScript functions or patterns.

    // Sanitize the script content by removing any harmful HTML/JS tags
    $allowed_tags = array();
    $script = wp_kses($script, $allowed_tags);

    // Remove backslashes added by WordPress
    $script = stripslashes($script);

    return $script;
}

// Inject the user-defined script in the footer
add_action('wp_footer', 'your_plugin_inject_script');
function your_plugin_inject_script() {
    $script = get_option('your_plugin_script');

    if (!empty($script)) {
        $script = your_plugin_sanitize_script($script);

        echo '<!-- Custom Script by Your Plugin -->' . PHP_EOL;
        echo '<script type="text/javascript">' . PHP_EOL;
        echo do_shortcode('[execute_script]' . $script . '[/execute_script]') . PHP_EOL;
        echo '</script>' . PHP_EOL;
    }
}