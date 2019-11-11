<?php
namespace WpPerDim\WordPress\Admin;

/**
 * SettingsGeneral
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class SettingsGeneral extends SettingsPage {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'general';
		$this->label = __( 'General', 'WpPerDim' );

		parent::__construct();
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_settings() {

		$settings = apply_filters(
			'WpPerDim_general_settings',
			array(

				array(
					'title' => __( 'General Settings', 'WpPerDim' ),
					'type'  => 'title',
					'desc'  => __( 'Description', 'WpPerDim' ),
					'id'    => 'nxw_store_address',
				),

                array(
                    'title'    => __( 'Panier', 'WpPerDim' ),
                    'desc'     => __( 'Saississez le nombre maximum de produit par panier.', 'WpPerDim' ),
                    'id'       => 'WpPerDim_cart_items_count',
                    'type'     => 'number',
                    'default'  => 2,
                ),

                array(
                    'title'    => __( 'Durée de nouvel achat', 'WpPerDim' ),
                    'desc'     => __( 'Saississez la durée en heure de 2 achats.', 'WpPerDim' ),
                    'id'       => 'WpPerDim_checkout_time_limit',
                    'type'     => 'number',
                    'default'  => 1,
                ),

                array(
                    'title'    => __( 'Login page', 'WpPerDim' ),
                    'desc'     => "",
                    'id'       => 'WpPerDim_login_page_id',
                    'type'     => 'single_select_page',
                    'default'  => '',
                    'class'    => 'wc-enhanced-select-nostd',
                    'css'      => 'min-width:300px;',
                    'desc_tip' => __( 'Selectionner ici la page contenant le shortocode [WpPerDim_login_form]', 'WpPerDim' ),
                ),

                array(
                    'title'    => __( 'Registration page', 'WpPerDim' ),
                    'desc'     => "",
                    'id'       => 'WpPerDim_register_page_id',
                    'type'     => 'single_select_page',
                    'default'  => '',
                    'class'    => 'wc-enhanced-select-nostd',
                    'css'      => 'min-width:300px;',
                    'desc_tip' => __( 'Selectionner ici la page contenant le shortocode [WpPerDim_register_form]', 'WpPerDim' ),
                ),
				
				// Ajout par Fulgence 20191009
				array(
                    'title'    => __( 'Password page', 'WpPerDim' ),
                    'desc'     => "",
                    'id'       => 'WpPerDim_forgot_page_id',
                    'type'     => 'single_select_page',
                    'default'  => '',
                    'class'    => 'wc-enhanced-select-nostd',
                    'css'      => 'min-width:300px;',
                    'desc_tip' => __( 'Selectionner ici la page contenant le shortocode [WpPerDim_forgot_form]', 'WpPerDim' ),
				),
				// Fin ajout Fulgence
				
				array(
					'type' => 'sectionend',
					'id'   => 'nxw_store_address',
				),

			)
		);

		return apply_filters( 'WpPerDim_get_settings_' . $this->id, $settings );
	}
}