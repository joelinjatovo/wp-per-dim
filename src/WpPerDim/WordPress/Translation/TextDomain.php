<?php
namespace WpPerDim\WordPress\Translation;

use WpPerDim\Interfaces\HooksInterface;

use WpPerDim\WordPress\Helpers\PostType;

/**
 * TextDomain
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class TextDomain implements HooksInterface{

    /**
     * @see WpPerDim\Interfaces\HooksInterface
     */
    public function hooks(){
        //add_action( 'init', array( $this, 'load_textdomain' ) );
        //add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
        $this->load_textdomain();
    }
			
    /**
     * Load plugin textdomain.
     */
    public function load_textdomain() {
        $plugin_rel_path = 'WpPerDim/languages/';
        load_plugin_textdomain('WpPerDim', false, $plugin_rel_path );
    }
    
}