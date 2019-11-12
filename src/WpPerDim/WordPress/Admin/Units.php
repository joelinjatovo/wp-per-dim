<?php
namespace WpPerDim\WordPress\Admin;

/**
 * Units
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class Units extends WelcomePage{

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'wppd-units';
		$this->label = __( 'Units List', 'wppd' );
		parent::__construct();
	}

    /**
     * Show list
     */
    public function output() {
        include WPPD_DIR . '/template/admin/units.php';
    }

    /**
     * Run POST request.
     * Override
     */
    public function save() {
        $languages = [];
        $en = Welcome::get_post('wppd_en_sync', '');
        if( ! empty($en)){
            $languages[] = 'en';
        }
        
        $fr = Welcome::get_post('wppd_fr_sync', '');
        if( ! empty($fr)){
            $languages[] = 'fr';
        }
        
        if( count( $languages ) == 0 ){
            Welcome::add_error( __( 'No catalog language selected.', 'nexway' ) );
            return;
        }
        
        $has_post = false;
        if( $has_post === false ) {
            Welcome::add_error( __( 'No catalog type selected [full|software|game].', 'nexway' ) );
        }
    }
}