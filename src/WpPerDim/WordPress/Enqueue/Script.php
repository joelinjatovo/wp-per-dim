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
        wp_enqueue_script('jquery');
        wp_enqueue_script('am4chart-core', WPPD_URL . "/assets/plugins/am4chart/core.js", array('jquery'), null, true);
        wp_enqueue_script('am4chart', WPPD_URL . "/assets/plugins/am4chart/charts.js", array('jquery', 'am4chart-core'), null, true);
        wp_enqueue_script('am4chart-animated', WPPD_URL . "/assets/plugins/am4chart/animated.js", array('jquery', 'am4chart'), null, true);
        wp_enqueue_script('am4chart-material', WPPD_URL . "/assets/plugins/am4chart/material.js", array('jquery', 'am4chart'), null, true);
        wp_enqueue_script('wppd-script', WPPD_URL . "/assets/js/script.js", array('jquery', 'am4chart'), null, true);
    }
    
    public function admin_script(){
        wp_enqueue_script('jquery-repeatable', WPPD_URL . "/assets/js/repeatable-fields.js", array('jquery', 'jquery-ui-core'), null, true);
        wp_enqueue_script('jquery-repeatable-init', WPPD_URL . "/assets/js/script.admin.js", array('jquery-repeatable'), null, true);
        wp_localize_script('jquery-repeatable-init', 'wppd_object_var', [
            'ajax_url'      => admin_url( 'admin-ajax.php' ),
            'error_message' => __('Une erreur s\'est produite. Veuillez réessayer!', 'wppd')
        ]);
    }
}