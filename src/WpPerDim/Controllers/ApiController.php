<?php
namespace WpPerDim\Controllers;

use WpPerDim\Systems\BaseController;

/**
 * ApiController
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 */
class ApiController extends BaseController{
    
    function __construct($view){
        parent::__construct($view);
    }
    
    public function game(\WP_REST_Request $request){
        $args = $request->get_params();
        
        $posts = get_posts(array(
            'ID' => $args['id'],
        ));

        if (empty($posts)){
            return new \WP_Error('no_post', __('Invalid post', 'WpPerDim'), array( 'status' => 404 ) );
        }

        $data = [
            'title' => $posts[0]->post_title,
        ];
        
        return new \WP_REST_Response($data, 200);
    }
}