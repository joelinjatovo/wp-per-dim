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
        $this->load_textdomain();
    }
			
    /**
     * Load plugin textdomain.
     */
    public function load_textdomain() {
        $plugin_rel_path = 'wp-per-dim/languages/';
        load_plugin_textdomain('wppd', false, $plugin_rel_path );
    }
    
}