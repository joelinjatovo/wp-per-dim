<?php
namespace WpPerDim\WordPress\Admin;

use WpPerDim\Models\App\Period;

/**
 * Periods
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class Periods extends WelcomePage{

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'wppd-periods';
		$this->label = __( 'Périodes', 'wppd' );
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
                    $model = Period::find($id);
                }
                if(!$model){ $model = new Period(); }
                
                $template = WPPD_DIR . '/template/admin/period/create.php';
                break;
            case 'show':
                $id = 0;
                $model = null;
                if( isset($_GET['id']) ) {
                    $id = (int) $_GET['id'];
                    $model = Period::find($id);
                }
                if(!$model){ $model = new Period(); }
                $template = WPPD_DIR . '/template/admin/period/show.php';
                break;
            case 'delete':
                $id = 0;
                $model = null;
                if( isset($_GET['id']) ) {
                    $id = (int) $_GET['id'];
                    $model = Period::find($id);
                    if($model){
                        $model->delete(); 
                    }
                }
                /** list all */
                $models = Period::getAll(0, 'order', 'ASC');
                $template = WPPD_DIR . '/template/admin/period/list.php';
                break;
            default:
                $models = Period::getAll(0, 'order', 'ASC');
                $template = WPPD_DIR . '/template/admin/period/list.php';
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
                    $model = Period::find($id);
                }
                if(!$model){ $model = new Period(); }
                
                if(isset($_POST['period-title'])){
                    $model->title = $_POST['period-title'];
                    $model->order = $_POST['period-order']??0;
                    $model->group = $_POST['period-group']??'';
                    $model->save();
                    Welcome::add_message(__('Votre modification a été bien enregistré.', 'nexway'));
                }
                
                break;
        }
    }
}