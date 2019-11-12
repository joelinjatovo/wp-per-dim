<?php
namespace WpPerDim\WordPress\Admin;

use WpPerDim\Models\App\Unit;

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
		$this->label = __( 'Unités', 'wppd' );
		parent::__construct();
	}

    /**
     * Show list
     */
    public function output() {
        $action = null;
        if( isset($_GET['action']) ) {
            $action = $_GET['action'];
        }
        
        switch($action){
            case 'create':
            case 'edit':
                $id = 0;
                $model = null;
                if( isset($_GET['id']) ) {
                    $id = (int) $_GET['id'];
                    $model = Unit::find($id);
                }
                if(!$model){ $model = new Unit(); }
                
                $template = WPPD_DIR . '/template/admin/unit/create.php';
                break;
            case 'show':
                $template = WPPD_DIR . '/template/admin/unit/show.php';
                break;
            default:
                $models = Unit::getAll();
                $template = WPPD_DIR . '/template/admin/unit/list.php';
                break;
        }
        
        if( file_exists( $template ) ) {
            include( $template );
        }
    }

    /**
     * Run POST request.
     * Override
     */
    public function save() {
        $action = null;
        if( isset($_GET['action']) ) {
            $action = $_GET['action'];
        }
        
        switch($action){
            case 'create':
            case 'edit':
                $id = 0;
                $model = null;
                if( isset($_GET['id']) ) {
                    $id = (int) $_GET['id'];
                    $model = Unit::find($id);
                }
                if(!$model){ $model = new Unit(); }
                
                if(isset($_POST['unit-title'])){
                    $model->title = $_POST['unit-title'];
                    $model->label = $_POST['unit-label'];
                    $model->save();
                    Welcome::add_message(__('Votre modification a été bien enregistré.', 'nexway'));
                }
                
                break;
        }
    }
}