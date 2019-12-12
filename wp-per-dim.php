<?php
/**
 * Plugin Name: WpPerDim
 * Description: Suivi des indicateurs
 * Version: 1.1.0
 * Author: 
 * Text Domain: WpPerDim
 * Domain Path: /languages
 */
require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );

if(!defined('WPPD_DIR'))    define('WPPD_DIR', plugin_dir_path(__FILE__));
if(!defined('WPPD_FILE'))   define('WPPD_FILE', __FILE__);
if(!defined('WPPD_URL'))    define('WPPD_URL', plugin_dir_url(__FILE__));

require_once('functions.php');

$actions = array(
    /** Translation & Script & Style */
    new WpPerDim\WordPress\Translation\TextDomain(),
    new WpPerDim\WordPress\Enqueue\Style(),
    new WpPerDim\WordPress\Enqueue\Script(),

    /** Shortcodes */
    new WpPerDim\WordPress\Shortcode\Shortcode(),
    
    /** Routing */
    /*
    new WpPerDim\WordPress\Routing\HomeTemplate(),
    new WpPerDim\WordPress\Rest\Api(),
    */
    new WpPerDim\WordPress\Rest\Ajax(),
    
    /** Admin Menu */
    new WpPerDim\WordPress\Admin\Menus(),
);

$wppd = new WpPerDim\WpPerDim($actions);
$wppd->execute(WPPD_FILE);