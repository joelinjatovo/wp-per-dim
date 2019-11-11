<?php
namespace WpPerDim\WordPress\Admin;

/**
 * WelcomePage
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class WelcomePage {
    /**
     * Welcome page id.
     *
     * @var string
     */
    protected $id = '';

    /**
     * Welcome page label.
     *
     * @var string
     */
    protected $label = '';

    /**
     * Constructor.
     */
    public function __construct() {
        add_filter( 'WpPerDim_welcomes_tabs_array', array( $this, 'add_welcomes_page' ), 20 );
        add_action( 'WpPerDim_welcomes_' . $this->id, array( $this, 'output' ) );
        add_action( 'WpPerDim_welcomes_save_' . $this->id, array( $this, 'save' ) );
    }

    /**
     * Add this page to settings.
     *
     * @param array $pages
     *
     * @return mixed
     */
    public function add_welcomes_page( $pages ) {
        $pages[ $this->id ] = $this->label;

        return $pages;
    }

    /**
     * Get welcomes array.
     *
     * @return array
     */
    public function get_welcomes() {
        return apply_filters( 'WpPerDim_get_welcomes_' . $this->id, array() );
    }

    /**
     * Output the welcomes.
     */
    public function output() {
        $welcomes = $this->get_welcomes();
        
        Welcome::output_fields( $welcomes );
    }

    /**
     * Save welcomes.
     */
    public function save() {
        $welcomes = $this->get_welcomes();
        
        Welcome::save_fields( $welcomes );
    }
}