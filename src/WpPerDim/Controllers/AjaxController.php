<?php
namespace WpPerDim\Controllers;

use WpPerDim\Systems\BaseController;
use WpPerDim\Models\Shop\Cart;
use WpPerDim\Models\Shop\Coupon;

/**
 * AjaxController
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 */
class AjaxController extends BaseController{
    
    function __construct($view){
        parent::__construct($view);
    }
    
    public function resendOrderEmail(){
        if ( isset( $_POST['order_id'] ) ){
            $order_id = wc_clean( wp_unslash( $_POST['order_id'] ) );
            if( $order_id ){
                return $this->json([
                   'state'      => 1,
                   'message'    => __('Order details manually sent by customer.', 'WpPerDim'),
                ]);
            }
        }
        return $this->json([
           'state'      => 0,
           'message'    => __('Les données sont invalides.', 'WpPerDim'),
           'error_code' => 'no_action',
        ]);
    }
}