<?php

register_activation_hook(TAG_MANAGER_PATH, array($this, 'plugin_activation'));

register_deactivation_hook(TAG_MANAGER_PATH, array($this, 'plugin_deactivation'));

// Run database cleanup on uninstall
register_uninstall_hook(TAG_MANAGER_PATH, array(__CLASS__, 'plugin_uninstall'));

//Activation hook
function plugin_activation() {
    // Code to be executed upon activation.
    // For example, set default options or perform setup tasks.
    add_option('your_plugin_option', 'default_value');

    // Register the custom post type on plugin activation
    $this->register_custom_post_type();
}

// Deactivation hook
function plugin_deactivation() {
    // Code to be executed upon deactivation.
    // For example, remove any temporary data or deactivate features.
    delete_option('your_plugin_option');
}

// Uninstall hook
function plugin_uninstall() {
    // Code to be executed upon uninstallation.
    // For example, remove any custom database tables or options.
    delete_option('your_plugin_option');
    // Additional cleanup tasks can be done here as needed.
}