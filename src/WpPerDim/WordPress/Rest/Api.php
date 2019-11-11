<?php
namespace WpPerDim\WordPress\Rest;

use WpPerDim\Interfaces\HooksInterface;
use WpPerDim\Controllers\ApiController;

/**
 * Api
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class Api implements HooksInterface{
    
    const END_POINT = 'WpPerDim/v1';

    /**
     * @see WpPerDim\Interfaces\HooksInterface
     */
    public function hooks(){
        add_action('rest_api_init', array($this, 'rest_api_init'));
    }
    
    public function rest_api_init(){
        global $WpPerDim;
        $controller = new ApiController($WpPerDim->view);
        
        register_rest_route(self::END_POINT, '/game/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array($controller, 'game'),
            'args' => array(
              'id' => array(
                'validate_callback' => function($param, $request, $key) {
                  return is_numeric($param);
                }
              ),
            ),
        ));
    }
}