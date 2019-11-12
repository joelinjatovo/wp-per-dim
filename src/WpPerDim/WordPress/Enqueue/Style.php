<?php
namespace WpPerDim\WordPress\Enqueue;

use WpPerDim\Interfaces\HooksInterface;

use WpPerDim\WordPress\Helpers\PostType;

/**
 * Style
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class Style implements HooksInterface{


    /**
     * @see WpPerDim\Interfaces\HooksInterface
     */
    public function hooks(){
        add_action("wp_enqueue_scripts",    array($this, 'front_style'), PHP_INT_MAX);
        add_action("admin_enqueue_scripts", array($this, 'admin_style'), PHP_INT_MAX);
    }
    
    public function front_style(){
        wp_register_style('wppd.style.css', WPPD_URL . "assets/css/style.css");
        wp_enqueue_style('wppd.style.css');
    }
    
    public function admin_style(){
        wp_register_style('wppd.admin.css', WPPD_URL . "assets/css/admin.css");
        wp_enqueue_style('wppd.admin.css');
    }
}