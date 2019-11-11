<?php
namespace WpPerDim\WordPress\Admin;

use WpPerDim\Interfaces\HooksInterface;

/**
 * Menus
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class Menus implements HooksInterface{

    /**
     * @see WpPerDim\Interfaces\HooksInterface
     */
    public function hooks(){
        add_action( "admin_menu", array($this, 'admin_menu') );
        add_action( "admin_menu", array($this, 'dashboard_menu') );
        add_action( "admin_menu", array($this, 'sync_menu') );
        add_action( "admin_menu", array($this, 'syncwoo_menu') );
        add_action( "admin_menu", array($this, 'xml_import_menu') );
        add_action( "admin_menu", array($this, 'settings_menu') );
    }
    
    public function admin_menu(){
        add_menu_page( __( 'WpPerDim', 'WpPerDim' ) , __( 'WpPerDim', 'WpPerDim' ), 'manage_options', 'WpPerDim', null, plugins_url( 'WpPerDim/assets/images/icon.png' ), 2);
    }
    
    public function dashboard_menu(){
        $welcome_page = add_submenu_page('WpPerDim', __( 'Welcome to WpPerDim', 'WpPerDim' ) , __( 'Welcome', 'WpPerDim' ), 'manage_options', 'WpPerDim', array($this, "welcome_page"), null, 0);
        
        add_action( 'load-' . $welcome_page, array( $this, 'welcome_page_init' ) );
    }
    
    public function sync_menu(){
        $sync_page = add_submenu_page('WpPerDim', __( 'WpPerDim Catalog', 'WpPerDim' ) , __( 'WpPerDim Catalogue', 'WpPerDim' ), 'manage_options', 'WpPerDim-sync', array($this, "sync_page"), null, 0);
        
        add_action( 'load-' . $sync_page, array( $this, 'welcome_page_init' ) );
    }
    
    public function syncwoo_menu(){
        $import_page = add_submenu_page('WpPerDim', __( 'Créer WooProduct', 'WpPerDim' ) , __( 'Créer WooProduct', 'WpPerDim' ), 'manage_options', 'WpPerDim-sync-woo', array($this, "sync_woo_page"), null, 0);
        
        add_action( 'load-' . $import_page, array( $this, 'welcome_page_init' ) );
    }
    
    public function xml_import_menu(){
        $import_page = add_submenu_page('WpPerDim', __( 'Importer un fichier XML', 'WpPerDim' ) , __( 'Importer XML', 'WpPerDim' ), 'manage_options', 'WpPerDim-import', array($this, "xml_import_page"), null, 0);
        
        add_action( 'load-' . $import_page, array( $this, 'welcome_page_init' ) );
    }
    
    public function settings_menu(){
        $settings_page = add_submenu_page('WpPerDim', __( 'WpPerDim Settings', 'WpPerDim' ) , __( 'Settings', 'WpPerDim' ), 'manage_options', 'WpPerDim-settings', array($this, "settings_page"), null, 0);
        
        add_action( 'load-' . $settings_page, array( $this, 'settings_page_init' ) );
    }
    
	/**
     *
	 */
	public function welcome_page_init() {
        global $current_page;
        
		// Include welcome pages.
		Welcome::get_pages();

        // Get current page.
		$current_page = empty( $_GET['page'] ) ? 'WpPerDim' : sanitize_title( wp_unslash( $_GET['page'] ) ); // WPCS: input var okay, CSRF ok.

		// Save welcomes if data has been posted.
		if ( apply_filters( "WpPerDim_save_welcomes_{$current_page}", ! empty( $_POST['save'] ) ) ) { // WPCS: input var okay, CSRF ok.
			Welcome::save();
		}

		// Add any posted messages.
		if ( ! empty( $_GET['nxw_error'] ) ) { // WPCS: input var okay, CSRF ok.
			Welcome::add_error( wp_kses_post( wp_unslash( $_GET['nxw_error'] ) ) ); // WPCS: input var okay, CSRF ok.
		}

		if ( ! empty( $_GET['nxw_message'] ) ) { // WPCS: input var okay, CSRF ok.
			Welcome::add_message( wp_kses_post( wp_unslash( $_GET['nxw_message'] ) ) ); // WPCS: input var okay, CSRF ok.
		}
        
		do_action( 'WpPerDim_welcome_page_init' );
	}
    
	/**
     *
	 */
	public function settings_page_init() {
        global $current_WpPerDim_tab;
        
		// Include settings pages.
		Settings::get_pages();

		// Get current tab/section.
		$current_WpPerDim_tab = empty( $_GET['tab'] ) ? 'general' : sanitize_title( wp_unslash( $_GET['tab'] ) ); // WPCS: input var okay, CSRF ok.

		// Save settings if data has been posted.
		if ( apply_filters( "WpPerDim_save_settings_{$current_WpPerDim_tab}", ! empty( $_POST['save'] ) ) ) { // WPCS: input var okay, CSRF ok.
			Settings::save();
		}

		// Add any posted messages.
		if ( ! empty( $_GET['nxw_error'] ) ) { // WPCS: input var okay, CSRF ok.
			Settings::add_error( wp_kses_post( wp_unslash( $_GET['nxw_error'] ) ) ); // WPCS: input var okay, CSRF ok.
		}

		if ( ! empty( $_GET['nxw_message'] ) ) { // WPCS: input var okay, CSRF ok.
			Settings::add_message( wp_kses_post( wp_unslash( $_GET['nxw_message'] ) ) ); // WPCS: input var okay, CSRF ok.
		}

		do_action( 'WpPerDim_settings_page_init' );
	}
    
    public function welcome_page(){
        Welcome::output();
    }
    
    public function xml_import_page(){
        Welcome::output();
    }
    
    public function sync_woo_page(){
        Welcome::output();
    }
    
    public function sync_page(){
        Welcome::output();
    }
    
    public function settings_page(){
        Settings::output();
    }
}