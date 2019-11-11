<?php
namespace WpPerDim\WordPress\Admin;

/**
 * Dashboard
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class Dashboard extends WelcomePage {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'WpPerDim';
		$this->label = __( 'Welcome', 'WpPerDim' );
		parent::__construct();
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_welcomes() {

		$welcomes = apply_filters(
			'WpPerDim_dashboard_welcomes',
			array(

				array(
					'type'  => 'title',
					'title' => __( 'Dashboard', 'WpPerDim' ),
					'desc'  => __( 'Description', 'WpPerDim' ),
					'id'    => 'nxw_dashboard',
				),

				array(
					'type'  => 'notice',
					'class' => 'WpPerDim-notice WpPerDim-notice-important',
					//'title' => __( 'Important', 'WpPerDim' ),
					'desc'  => __( 'Notice', 'woocommerce' ),
					'id'    => 'dashboard-notice',
				),

				array(
					'type' => 'sectionend',
					'id'   => 'nxw_dashboard',
				),

			)
		);

		return apply_filters( 'WpPerDim_get_welcomes_' . $this->id, $welcomes );
	}
}