<?php
/**
 * Plugin Name: Marketing Tag Manager
 * Description: Tag manager plugin (not only) for Marketing team!
 * Version: 1.0.0
 * Requires at least: 6.2
 * Requires PHP: 8.0
 * Author: Lena Sędkiewicz
 * Author URI: https://msedkiewicz.pl/
 * License: GPLv2 or later
 * Text Domain: tagmanager
 * Domain Path:  /languages
*/

if( !defined('ABSPATH') ){
    die('Go and watch LOTR!');
};

if( !class_exists('TagManagerMsedkiewicz')) {
    class TagManagerMsedkiewicz {
        // Constructor method to initialize the plugin
        public function __construct() {
            define('TAG_MANAGER_PATH', plugin_dir_path( __FILE__ ));
            // Add activation and deactivation hooks
        }

        public function initialize(){
            include_once TAG_MANAGER_PATH . 'includes/utilities.php';

            include_once TAG_MANAGER_PATH . 'includes/cpt.php';

            include_once TAG_MANAGER_PATH . 'includes/options-panel.php';
        }
    }

$tagManager = new TagManagerMsedkiewicz;
$tagManager->initialize();
}