<?php
namespace WpPerDim\WordPress\Routing;

use WpPerDim\Interfaces\HooksInterface;
use WpPerDim\Controllers\ShopController;
use WpPerDim\Controllers\AjaxController;
use WpPerDim\WordPress\Helpers\Form;
use WpPerDim\Models\Security\Nonce;
use WpPerDim\Systems\Request;

/**
 * HomeTemplate
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class HomeTemplate implements HooksInterface{

    /**
     * @see WpPerDim\Interfaces\HooksInterface
     */
    public function hooks(){
        add_action("wp_head", array($this, 'wp_head'));
    }
    
    public function wp_head() {
        echo '<div class="preloader" style="display: none;">
                <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
                </svg>
            </div>';
    }
}