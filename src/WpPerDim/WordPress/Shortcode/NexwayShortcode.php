<?php
namespace WpPerDim\WordPress\Shortcode;

use WpPerDim\Interfaces\HooksInterface;

/**
 * WpPerDimShortcode
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class WpPerDimShortcode implements HooksInterface{

    /**
     * @see WpPerDim\Interfaces\HooksInterface
     */
    public function hooks(){
        add_shortcode( "WpPerDim_slider", array($this, 'WpPerDim_slider') );
        add_shortcode( "WpPerDim_category_slider", array($this, 'WpPerDim_category_slider') );
        add_shortcode( "WpPerDim_login_form", array($this, 'form_login') );
        add_shortcode( "WpPerDim_register_form", array($this, 'form_register'));
        // add_action( 'woocommerce_after_customer_login_form', [ $this, 'registration_redirects' ], 10 );

    }
    
    public function WpPerDim_category_slider($atts){
        return $this->WpPerDim_slider($atts);
    }
    
    public function WpPerDim_slider($atts){
        $default = array(
			'limit'        => '12',
			'columns'      => '6',
			'orderby'      => 'rand',
			'order'        => 'DESC',
			'category'     => '',
			'cat_operator' => 'IN',
			'featured'     => true,
			'new'          => false,
			'top'          => false,
        );
        
        ob_start();
        $attributes = shortcode_atts($default, (array) $atts);
        include( NXW_DIR . '/template/slider.php');
        return ob_get_clean();
    }


    public function form_register(){
        ob_start();
        include( NXW_DIR . '/template/form-register.php');
        return ob_get_clean();
    }

    public function form_login(){
        if ( is_admin() ) return '';
       
        if ( is_user_logged_in() ) return '';

        ob_start();
        echo '<div id="login_front">';
            include( NXW_DIR . '/template/form-login.php');
        echo '</div>';
        return ob_get_clean();
    }

}