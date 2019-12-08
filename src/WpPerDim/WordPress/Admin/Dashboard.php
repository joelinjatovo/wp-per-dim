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
		$this->id    = 'wppd';
		$this->label = __( 'Shortcodes', 'wppd' );
		parent::__construct();
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_welcomes() {

		$welcomes = apply_filters(
			'wppd_dashboard_welcomes',
			array(

				array(
					'type'  => 'title',
					'title' => __( 'Shortcodes', 'wppd' ),
					//'desc'  => __( 'Description', 'wppd' ),
					'id'    => 'wppd_dashboard',
				),

				array(
					'type'  => 'notice',
					'class' => 'wppd-notice wppd-notice-important',
					'title' => __( 'Gaphe', 'wppd' ),
					'desc'  => __( 'Utilisez le shortcode <code>[wppd_graph organism="0|integer"]</code> pour afficher le graphe.', 'wppd' ),
					'id'    => 'dashboard-notice',
				),

				array(
					'type'  => 'notice',
					'class' => 'wppd-notice wppd-notice-important',
					'title' => __( 'Tableau de bord', 'wppd' ),
					'desc'  => __( 'Utilisez le shortcode <code>[wppd_dashboard organism="0|integer" type="km|cf"]</code> pour afficher le tableau de bord km ou cf.', 'wppd' ),
					'id'    => 'dashboard-notice',
				),

				array(
					'type' => 'sectionend',
					'id'   => 'wppd_dashboard',
				),

			)
		);

		return apply_filters( 'wppd_get_welcomes_' . $this->id, $welcomes );
	}
}