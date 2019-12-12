<?php
namespace WpPerDim\WordPress\Rest;

use WpPerDim\Interfaces\HooksInterface;
use WpPerDim\Controllers\ApiController;
use WpPerDim\Controllers\AjaxController;

/**
 * Ajax
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class Ajax implements HooksInterface{
    
    /**
     * @see WpPerDim\Interfaces\HooksInterface
     */
    public function hooks(){
        global $WpPerDim;
        $controller = new AjaxController($WpPerDim->view);

        add_action('wp_ajax_select_organism', array($controller, 'selectOrganism'));
    }
}