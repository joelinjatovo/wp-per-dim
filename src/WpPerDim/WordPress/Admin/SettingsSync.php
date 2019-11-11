<?php
namespace WpPerDim\WordPress\Admin;

/**
 * SettingsSync
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class SettingsSync extends SettingsPage {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'sync';
		$this->label = __( 'Synchronisation', 'WpPerDim' );

		parent::__construct();
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_settings() {

		$settings = apply_filters(
			'WpPerDim_sync_settings',
			array(

				array(
					'title' => __( 'Synchronisation', 'WpPerDim' ),
					'type'  => 'title',
					'desc'  => __( 'This is where your business is located. Tax rates and shipping rates will use this address.', 'woocommerce' ),
					'id'    => 'nxw_sync_product',
				),

				array(
					'title'           => __( 'Downloaded Catalog', 'WpPerDim' ),
					'desc'            => __( 'Check if you want to remove downloaded catalog file after importation.', 'WpPerDim' ),
					'id'              => 'WpPerDim_unlink_downloaded_file',
					'default'         => 'yes',
					'type'            => 'checkbox',
					'show_if_checked' => 'option',
					'desc_tip'        => __( 'Sync Product download xml product catalog from WpPerDim and create file on the server.', 'WpPerDim' ),
				),

				array(
					'title'           => __( 'Enable Full Sync', 'WpPerDim' ),
					'desc'            => __( 'Enable full product synchronization schedule.', 'WpPerDim' ),
					'id'              => 'WpPerDim_full_sync_enabled',
					'default'         => 'yes',
					'type'            => 'checkbox',
					'show_if_checked' => 'option',
					'desc_tip'        => __( 'Full cron download "full catalogue" from WpPerDim and import in woocommerce product database.', 'WpPerDim' ),
				),

				array(
					'title'           => __( 'Enable Software Sync', 'WpPerDim' ),
					'desc'            => __( 'Enable software product synchronization schedule.', 'WpPerDim' ),
					'id'              => 'WpPerDim_software_sync_enabled',
					'default'         => 'yes',
					'type'            => 'checkbox',
					'show_if_checked' => 'option',
					'desc_tip'        => __( 'Software cron download "software catalogue" from WpPerDim and import in woocommerce product database.', 'WpPerDim' ),
				),

				array(
					'title'           => __( 'Enable Game Sync', 'WpPerDim' ),
					'desc'            => __( 'Enable game product synchronization schedule.', 'WpPerDim' ),
					'id'              => 'WpPerDim_game_sync_enabled',
					'default'         => 'yes',
					'type'            => 'checkbox',
					'show_if_checked' => 'option',
					'desc_tip'        => __( 'Game cron download "game catalogue" from WpPerDim and import in woocommerce product database.', 'WpPerDim' ),
				),

				array(
					'type' => 'sectionend',
					'id'   => 'nxw_sync_product',
				),

			)
		);

		return apply_filters( 'WpPerDim_get_settings_' . $this->id, $settings );
	}
}