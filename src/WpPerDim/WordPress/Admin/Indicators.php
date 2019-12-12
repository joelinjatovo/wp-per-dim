<?php
namespace WpPerDim\WordPress\Admin;

use WpPerDim\Models\App\Indicator;
use WpPerDim\Models\App\Period;
use WpPerDim\Models\App\Unit;
use WpPerDim\Models\App\Organism;

/**
 * Indicators
 *
 * @author JOELINJATOVO Haja
 * @version 1.0.0
 * @since 1.0.0
 */
class Indicators extends WelcomePage{

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'wppd-indicators';
		$this->label = __( 'Indicateurs', 'wppd' );
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
                    $model = Indicator::find($id);
                }
                if(!$model){ $model = new Indicator(); }
                $units = Unit::getAll();
                $organisms = Organism::getAll();
                
                $template = WPPD_DIR . '/template/admin/indicator/create.php';
                break;
            case 'show':
                $id = 0;
                $model = null;
                if( isset($_GET['id']) ) {
                    $id = (int) $_GET['id'];
                    $model = Indicator::find($id);
                }
                if(!$model){ $model = new Indicator(); }
                $template = WPPD_DIR . '/template/admin/indicator/show.php';
                break;
            case 'delete':
                $id = 0;
                $model = null;
                if( isset($_GET['id']) ) {
                    $id = (int) $_GET['id'];
                    $model = Indicator::find($id);
                    if($model){
                        $model->delete(); 
                    }
                }
                
                /* render list */
                $indicators = Indicator::getAll();
                $models = [];
                foreach($indicators as $indicator){
                    $models[] = Indicator::fromWp($indicator);
                }
                $template = WPPD_DIR . '/template/admin/indicator/list.php';
                break;
            default:
                $indicators = Indicator::getAll();
                $models = [];
                foreach($indicators as $indicator){
                    $models[] = Indicator::fromWp($indicator);
                }
                $template = WPPD_DIR . '/template/admin/indicator/list.php';
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
                    $model = Indicator::find($id);
                }
                if(!$model){ $model = new Indicator(); }
                
                if(isset($_POST['indicator-title'])){
                    $model->title = $_POST['indicator-title'];
                    $model->description = $_POST['indicator-description'];
                    $model->unit_id = $_POST['indicator-unit'];
                    $model->organism_id = $_POST['indicator-organism'];
                    $model->type = $_POST['indicator-type']??'cf';
                    $model->graph = $_POST['indicator-graph'];
                    $model->save();
                    
                    Welcome::add_message(__('Votre modification a été bien enregistré.', 'nexway'));
                }
                
                break;
        }
    }
}