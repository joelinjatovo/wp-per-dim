<?php
namespace WpPerDim\WordPress\Admin;

/**
 * SyncProduct
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class SyncProduct extends WelcomePage{

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'WpPerDim-sync';
		$this->label = __( 'WpPerDim Catalogue', 'WpPerDim' );
		parent::__construct();
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_welcomes() {

		$welcomes = apply_filters(
			'WpPerDim_sync_welcomes',
			array(

				array(
					'title' => __( 'Synchronisation depuis WpPerDim vers Database', 'WpPerDim' ),
					'type'  => 'title',
					'desc'  => __( 'Allow to download WpPerDim product catalogue and import immediately to woocommerce product.', 'WpPerDim' ),
					'id'    => 'nxw_sync',
				),

				array(
					'id'              => 'nxw-table',
					'type'            => 'table-start',
				),

				array(
					'title'           => __( 'Catalog Language', 'WpPerDim' ),
					'desc'            => __( 'Download EN Catalog from WpPerDim.', 'WpPerDim' ),
					'id'              => 'WpPerDim_en_sync',
					'default'         => 'no',
					'type'            => 'checkbox',
                    'checkboxgroup'   => 'start',
					'show_if_checked' => 'option',
				),

				array(
					'title'           => __( 'Catalog Language', 'WpPerDim' ),
					'desc'            => __( 'Download FR Catalog from WpPerDim.', 'WpPerDim' ),
					'id'              => 'WpPerDim_fr_sync',
					'default'         => 'no',
					'type'            => 'checkbox',
                    'checkboxgroup'   => 'end',
					'show_if_checked' => 'option',
				),

				array(
					'title'           => __( 'Full Sync', 'WpPerDim' ),
					'desc'            => __( 'Run full product synchronization now with the selected language.', 'WpPerDim' ),
					'id'              => 'WpPerDim_full_sync',
					'default'         => 'no',
					'type'            => 'checkbox',
					'show_if_checked' => 'option',
				),

				array(
					'title'           => __( 'Software Sync', 'WpPerDim' ),
					'desc'            => __( 'Run software product synchronization now with the selected language.', 'WpPerDim' ),
					'id'              => 'WpPerDim_software_sync',
					'default'         => 'no',
					'type'            => 'checkbox',
					'show_if_checked' => 'option',
				),

				array(
					'title'           => __( 'Game Sync', 'WpPerDim' ),
					'desc'            => __( 'Run game product synchronization now with the selected language.', 'WpPerDim' ),
					'id'              => 'WpPerDim_game_sync',
					'default'         => 'no',
					'type'            => 'checkbox',
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
        $languages = [];
        $en = Welcome::get_post('WpPerDim_en_sync', '');
        if( ! empty($en)){
            $languages[] = 'en';
        }
        
        $fr = Welcome::get_post('WpPerDim_fr_sync', '');
        if( ! empty($fr)){
            $languages[] = 'fr';
        }
        
        if( count( $languages ) == 0 ){
            Welcome::add_error( __( 'No catalog language selected.', 'WpPerDim' ) );
            return;
        }
        
        $has_post = false;
        foreach($languages as $language){
            $keys = ['full', 'software', 'game'];
            foreach($keys as $key){
                $value = Welcome::get_post('WpPerDim_'.$key.'_sync', false);
                if($value !== false) {
                    $has_post = true;
                    $result = null;
                    
                    switch($key) {
                        case 'full':
                            try{
                                $result = \WpPerDim\WordPress\Schedule\FullSync::sync($language);
                            }catch(\Exception $e){
                                Welcome::add_error( __( 'An error has occured when syncing.', 'WpPerDim' ).' '.$e->getMessage() );
                            }
                        break;

                        case 'software':
                            try{
                                $result = \WpPerDim\WordPress\Schedule\SoftwareSync::sync($language);
                            }catch(\Exception $e){
                                Welcome::add_error( __( 'An error has occured when syncing.', 'WpPerDim' ).' '.$e->getMessage() );
                            }
                        break;

                        case 'game':
                            try{
                                $result = \WpPerDim\WordPress\Schedule\GameSync::sync($language);
                            }catch(\Exception $e){
                                Welcome::add_error( __( 'An error has occured when syncing.', 'WpPerDim' ).' '.$e->getMessage() );
                            }
                        break;
                    }
                    
                    if( isset( $result ) && is_array( $result ) ){
                        Welcome::add_message(__('Catalog downloaded successfully.', 'WpPerDim'));
                    }
                }
            }
        }
        
        if( $has_post === false ) {
            Welcome::add_error( __( 'No catalog type selected [full|software|game].', 'WpPerDim' ) );
        }
    }
}