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
        //wp_register_script('itrans.js', KSK_ASSETS_URL . "/plug/itrans/js/main.min.js", array(), null, true);
        //wp_enqueue_script('itrans.js');	
    }
}