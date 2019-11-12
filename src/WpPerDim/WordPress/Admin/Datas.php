<?php
namespace WpPerDim\WordPress\Admin;

use WpPerDim\Models\App\Report;

/**
 * Datas
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class Datas extends WelcomePage{

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'wppd-datas';
		$this->label = __( 'Données', 'wppd' );
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
                    $model = Report::find($id);
                }
                if(!$model){ $model = new Report(); }
                
                $template = WPPD_DIR . '/template/admin/report/create.php';
                break;
            case 'show':
                $template = WPPD_DIR . '/template/admin/report/show.php';
                break;
            default:
                $models = Report::getAll();
                $template = WPPD_DIR . '/template/admin/report/list.php';
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
                    $model = Report::find($id);
                }
                if(!$model){ $model = new Report(); }
                
                if(isset($_POST['report-title'])){
                    $model->title = $_POST['report-title'];
                    $model->save();
                    Welcome::add_message(__('Votre modification a été bien enregistré.', 'nexway'));
                }
                
                break;
        }
    }
}