<?php
namespace WpPerDim\WordPress\Admin;

/**
 * SyncWooProduct
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class SyncWooProduct extends WelcomePage{

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'WpPerDim-sync-woo';
		$this->label = __( 'Créer WooProduct', 'WpPerDim' );
		parent::__construct();
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_welcomes() {
        
        global $wpdb;
        
        $table_name = $wpdb->prefix.'nxw_products';
        $row = $wpdb->get_row("SELECT count(nxw_product_id) as nbr FROM $table_name WHERE wp_post_id IS NULL;");
        $count = (int) $row->nbr;

		$welcomes = apply_filters(
			'WpPerDim_syncwoo_welcomes',
			array(

				array(
					'title' => __( 'Synchronisation Database vers WooProduct', 'WpPerDim' ),
					'type'  => 'title',
					'desc'  => __( 'Allow to sync WpPerDim product catalogue with WooCommerce Product.', 'WpPerDim' ).
                                ' <br>' . sprintf( _n( 'You have %s new catalogue to synchronize.', 'You have %s new catalogues to synchronize.', $count, 'WpPerDim' ), number_format_i18n( $count ) ),
					'id'    => 'nxw_sync',
				),

				array(
					'id'              => 'nxw-table',
					'type'            => 'table-start',
				),

				array(
					'title'           => __( 'Sync WooProduct', 'WpPerDim' ),
					'desc'            => __( 'Create WooCommerce Product from WpPerDim database', 'WpPerDim' ),
					'id'              => 'WpPerDim_product_sync',
					'default'         => 'no',
					'type'            => 'checkbox',
					'show_if_checked' => 'option',
				),

				array(
					'title'           => __( 'Syn OSGroup Terms', 'WpPerDim' ),
					'desc'            => __( 'Add WooCommerce Product in the related term group', 'WpPerDim' ),
					'id'              => 'WpPerDim_osgroup_sync',
					'default'         => 'no',
					'type'            => 'checkbox',
					'show_if_checked' => 'option',
				),

				array(
					'title'           => __( 'OSGroup Page', 'WpPerDim' ),
					'id'              => 'WpPerDim_osgroup_page',
					'default'         => 1,
					'value'           => Welcome::get_post('WpPerDim_osgroup_page', 0) + 1,
					'type'            => 'number',
					'show_if_checked' => 'option',
				),

				array(
					'id'              => 'nxw-end',
					'type'            => 'table-end',
				),

				array(
					'type' => 'sectionend',
					'id'   => 'nxw_sync',
				),

				array(
					'type' => 'submit',
					'title' => __( 'Run Sync Now', 'WpPerDim' ),
					'id'   => 'nxw_submit',
				),

			)
		);

		return apply_filters( 'WpPerDim_get_welcomes_' . $this->id, $welcomes );
	}

    /**
     * Run POST request.
     * Override
     */
    public function save() {
        $value = Welcome::get_post('WpPerDim_product_sync', false);
        if($value !== false) {
            try{
                $result = (int) \WpPerDim\WordPress\Schedule\DatabaseSync::sync(50);
                Welcome::add_message( sprintf( _n( '%s new product imported.', '%s new products imported.', $result, 'WpPerDim' ), $result ) );
            }catch(\Exception $e){
                Welcome::add_error( __( 'An error has occured when syncing.', 'WpPerDim' ).' '.$e->getMessage() );
            }
        }
        
        $value = Welcome::get_post('WpPerDim_osgroup_sync', false);
        if($value !== false) {
            try{
                $page = Welcome::get_post('WpPerDim_osgroup_page', 1);
                $result = \WpPerDim\WordPress\Schedule\DatabaseSync::syncOsGroups($page);
                
                if( $result == false ){
                    Welcome::add_error( __( 'No product found', 'WpPerDim' ));
                }else{
                    $result = (int) $result;
                    Welcome::add_message( sprintf( _n( '%s new product imported.', '%s new products imported.', $result, 'WpPerDim' ), $result ) );
                }
            }catch(\Exception $e){
                Welcome::add_error( __( 'An error has occured when syncing.', 'WpPerDim' ).' '.$e->getMessage() );
            }
        }
    }
}