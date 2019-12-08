<?php
namespace WpPerDim\WordPress\Admin;

use WpPerDim\Models\App\Organism;

/**
 * Organisms
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class Organisms extends WelcomePage{

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'wppd-organisms';
		$this->label = __( 'Organismes', 'wppd' );
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
                    $model = Organism::find($id);
                }
                if(!$model){ $model = new Organism(); }
                
                $template = WPPD_DIR . '/template/admin/organism/create.php';
                break;
            case 'show':
                $id = 0;
                $model = null;
                if( isset($_GET['id']) ) {
                    $id = (int) $_GET['id'];
                    $model = Organism::find($id);
                }
                if(!$model){ $model = new Organism(); }
                $template = WPPD_DIR . '/template/admin/organism/show.php';
                break;
            case 'delete':
                $id = 0;
                $model = null;
                if( isset($_GET['id']) ) {
                    $id = (int) $_GET['id'];
                    $model = Organism::find($id);
                    if($model){
                        $model->delete(); 
                    }
                }
                /** list all */
                $models = Organism::getAll();
                $template = WPPD_DIR . '/template/admin/organism/list.php';
                break;
            default:
                $models = Organism::getAll();
                $template = WPPD_DIR . '/template/admin/organism/list.php';
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
                    $model = Organism::find($id);
                }
                if(!$model){ $model = new Organism(); }
                
                if(isset($_POST['organism-title'])){
                    $model->title = $_POST['organism-title'];
                    $model->label = $_POST['organism-label'];
                    $model->save();
                    Welcome::add_message(__('Votre modification a été bien enregistré.', 'nexway'));
                }
                
                break;
        }
    }
}