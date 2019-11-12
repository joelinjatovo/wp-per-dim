<?php
namespace WpPerDim\WordPress\Enqueue;

use WpPerDim\Interfaces\HooksInterface;

use WpPerDim\WordPress\Helpers\PostType;

/**
 * Script
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class Script implements HooksInterface{


    /**
     * @see WpPerDim\Interfaces\HooksInterface
     */
    public function hooks(){
        add_action("wp_enqueue_scripts", array($this, 'front_script'), PHP_INT_MAX);
        add_action("admin_enqueue_scripts", array($this, 'admin_script'), PHP_INT_MAX);
    }
    
    public function front_script(){
    }
    
    public function admin_script(){
        wp_enqueue_script('jquery-repeatable', WPPD_URL . "/assets/js/repeatable-fields.js", array('jquery', 'jquery-ui-core'), null, true);
        wp_enqueue_script('jquery-repeatable-init', WPPD_URL . "/assets/js/script.admin.js", array('jquery-repeatable'), null, true);
        //wp_enqueue_script('wppd.repeatable.js');	
        wp_localize_script('wppd', 'wppd', [
            'ajax_url'      => admin_url( 'admin-ajax.php' ),
            'error_message' => __('Une erreur s\'est produite. Veuillez réessayer!', 'wppd')
        ]);
    }
}