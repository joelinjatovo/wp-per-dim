<?php
namespace WpPerDim\WordPress\Admin;

/**
 * SettingsCheckout
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class SettingsCheckout extends SettingsPage {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'checkout';
		$this->label = __( 'Checkout', 'WpPerDim' );

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
					'title' => __( 'Billing Form', 'WpPerDim' ),
					'type'  => 'title',
					'id'    => 'nxw_checkout_billing_form',
				),

                    array(
                        'title'           => __( 'First name', 'woocommerce' ),
                        'desc'            => __( 'Check to show "billing_first_name"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_billing_first_name',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
					    'desc_tip'        => __( 'This field is required by WpPerDimConnect API', 'WpPerDim' ),
                    ),

                    array(
                        'title'           => __( 'Last name', 'woocommerce' ),
                        'desc'            => __( 'Check to show "billing_last_name"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_billing_last_name',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
					    'desc_tip'        => __( 'This field is required by WpPerDimConnect API', 'WpPerDim' ),
                    ),

                    array(
                        'title'           => __( 'Company', 'woocommerce' ),
                        'desc'            => __( 'Check to show "billing_company"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_billing_company',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'Country', 'woocommerce' ),
                        'desc'            => __( 'Check to show "billing_country"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_billing_country',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
					    'desc_tip'        => __( 'This field is required by WpPerDimConnect API', 'WpPerDim' ),
                    ),

                    array(
                        'title'           => __( 'Address 1', 'woocommerce' ),
                        'desc'            => __( 'Check to show "billing_address_1"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_billing_address_1',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
					    'desc_tip'        => __( 'This field is required by WpPerDimConnect API', 'WpPerDim' ),
                    ),

                    array(
                        'title'           => __( 'Address 2', 'woocommerce' ),
                        'desc'            => __( 'Check to show "billing_address_2"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_billing_address_2',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'City', 'woocommerce' ),
                        'desc'            => __( 'Check to show "billing_city"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_billing_city',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
					    'desc_tip'        => __( 'This field is required by WpPerDimConnect API', 'WpPerDim' ),
                    ),

                    array(
                        'title'           => __( 'State', 'woocommerce' ),
                        'desc'            => __( 'Check to show "billing_state"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_billing_state',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'Postcode', 'woocommerce' ),
                        'desc'            => __( 'Check to show "billing_postcode"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_billing_postcode',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'Phone', 'woocommerce' ),
                        'desc'            => __( 'Check to show "billing_phone"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_billing_phone',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'Email address', 'woocommerce' ),
                        'desc'            => __( 'Check to show "billing_email"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_billing_email',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
					    'desc_tip'        => __( 'This field is required by WpPerDimConnect API', 'WpPerDim' ),
                    ),

				array(
					'type' => 'sectionend',
					'id'   => 'nxw_checkout_billing_form',
				),

				array(
					'title' => __( 'Shipping Form', 'WpPerDim' ),
					'type'  => 'title',
					'id'    => 'nxw_checkout_shipping_form',
				),

                    array(
                        'title'           => __( 'First name', 'woocommerce' ),
                        'desc'            => __( 'Check to show "shipping_first_name"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_shipping_first_name',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'Last name', 'woocommerce' ),
                        'desc'            => __( 'Check to show "shipping_last_name"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_shipping_last_name',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'Company', 'woocommerce' ),
                        'desc'            => __( 'Check to show "shipping_company"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_shipping_company',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'Country', 'woocommerce' ),
                        'desc'            => __( 'Check to show "shipping_country"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_shipping_country',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'Address 1', 'woocommerce' ),
                        'desc'            => __( 'Check to show "shipping_address_1"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_shipping_address_1',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'Address 2', 'woocommerce' ),
                        'desc'            => __( 'Check to show "shipping_address_2"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_shipping_address_2',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'City', 'woocommerce' ),
                        'desc'            => __( 'Check to show "shipping_city"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_shipping_city',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'State', 'woocommerce' ),
                        'desc'            => __( 'Check to show "shipping_state"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_shipping_state',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'Postcode', 'woocommerce' ),
                        'desc'            => __( 'Check to show "shipping_postcode"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_shipping_postcode',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'Phone', 'woocommerce' ),
                        'desc'            => __( 'Check to show "shipping_phone"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_shipping_phone',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

                    array(
                        'title'           => __( 'Email address', 'woocommerce' ),
                        'desc'            => __( 'Check to show "shipping_email"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_shipping_email',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

				array(
					'type' => 'sectionend',
					'id'   => 'nxw_checkout_shipping_form',
				),

				array(
					'title' => __( 'Order Form', 'WpPerDim' ),
					'type'  => 'title',
					'id'    => 'nxw_checkout_order_form',
				),

                    array(
                        'title'           => __( 'Order Comments', 'WpPerDim' ),
                        'desc'            => __( 'Check to show "order_comments"', 'WpPerDim' ),
                        'id'              => 'WpPerDim_show_order_comments',
                        'default'         => 'yes',
                        'type'            => 'checkbox',
                    ),

				array(
					'type' => 'sectionend',
					'id'   => 'nxw_checkout_order_form',
				),

			)
		);

		return apply_filters( 'WpPerDim_get_settings_' . $this->id, $settings );
	}
}