<?php
namespace WpPerDim\WordPress\Admin;

use WpPerDim\Models\App\Tracker;

/**
 * Trackers
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class Trackers extends WelcomePage{

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'wppd-trackers';
		$this->label = __( 'Suivis', 'wppd' );
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
                    $model = Tracker::find($id);
                }
                if(!$model){ $model = new Tracker(); }
                
                $template = WPPD_DIR . '/template/admin/tracker/create.php';
                break;
            case 'show':
                $id = 0;
                $model = null;
                if( isset($_GET['id']) ) {
                    $id = (int) $_GET['id'];
                    $model = Tracker::find($id);
                }
                if(!$model){ $model = new Tracker(); }
                $template = WPPD_DIR . '/template/admin/tracker/show.php';
                break;
            case 'delete':
                $id = 0;
                $model = null;
                if( isset($_GET['id']) ) {
                    $id = (int) $_GET['id'];
                    $model = Tracker::find($id);
                    if($model){
                        $model->delete(); 
                    }
                }
                /** list all */
                $models = Tracker::getAll();
                $template = WPPD_DIR . '/template/admin/tracker/list.php';
                break;
            default:
                $models = Tracker::getAll();
                $template = WPPD_DIR . '/template/admin/tracker/list.php';
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
                    $model = Tracker::find($id);
                }
                if(!$model){ $model = new Tracker(); }
                
                if(isset($_POST['tracker-title'])){
                    $model->title = $_POST['tracker-title'];
                    $model->save();
                    Welcome::add_message(__('Votre modification a été bien enregistré.', 'nexway'));
                }
                
                break;
        }
    }
}