<?php
namespace WpPerDim\WordPress\Admin;

use WpPerDim\Models\App\Report;
use WpPerDim\Models\App\Indicator;
use WpPerDim\Models\App\Organism;
use WpPerDim\Models\App\Result;

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
                
                $models = Organism::getAll();
                $organisms = [];
                foreach($models as $organism){
                    $organisms[] = Organism::fromWp($organism);
                }
                
                $models = Indicator::getAll();
                $indicators = [];
                foreach($models as $indicator){
                    $indicators[] = Indicator::fromWp($indicator);
                }
                
                $template = WPPD_DIR . '/template/admin/report/create.php';
                break;
            case 'show':
                $id = 0;
                $model = null;
                if( isset($_GET['id']) ) {
                    $id = (int) $_GET['id'];
                    $model = Report::find($id);
                }
                if(!$model){ $model = new Report(); }
                $template = WPPD_DIR . '/template/admin/report/show.php';
                break;
            case 'delete':
                $id = 0;
                $model = null;
                if( isset($_GET['id']) ) {
                    $id = (int) $_GET['id'];
                    $model = Report::find($id);
                    if($model){
                        $model->delete(); 
                    }
                }
                /** list all */
                $models = Report::getAll();
                $template = WPPD_DIR . '/template/admin/report/list.php';
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
                
                if( isset($_POST['report-organism']) && is_int($_POST['report-organism']) ){
                    $_organism = Organism::find((int) $_POST['report-organism'] );
                    if( $_organism ){
                        if(isset($_POST['reports']) && is_array($_POST['reports']) ){
                            $reports = $_POST['reports'];
                            foreach($reports as $report){
                                if( isset($report['indicator']) && is_int($report['indicator']) ) {
                                    $_indicator = Indicator::find((int) $report['indicator']);
                                    if($_indicator){
                                        // Save or Update Report
                                        $_report = Report::getFirstBy('indicator_id', $report['indicator']);
                                        if(!$_report){
                                            $_report = new Report();
                                            $_report->title = sprintf(__("Rapport de l'indicateur: %s", 'wppd'), $_indicator->title);
                                            $_report->indicator_id = $_indicator->getPkValue();
                                            $_report->save();
                                        }

                                        // Save Result
                                        if(isset($report['results']) && is_array($report['results']) ){
                                            $results = $report['results'];
                                            foreach($results as $result){
                                                $_result = Result::find((int) $result['id']);
                                                if(!$_result){
                                                    $_result = new Result();
                                                }
                                                $_result->report_id = $_report->getPkValue();
                                                $_result->value     = (int) $result['value'];
                                                $_result->period_id = (int) $result['period'];
                                                $_result->save();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        
                        Welcome::add_message(__('Votre modification a été bien enregistré.', 'nexway'));
                    }else{
                        Welcome::add_error(__('Votre demande n\'a pas été abouti. Une erreur est survenue. Veuillez-réessayer s\'il vous plaît!', 'nexway'));
                    }
                    
                }
                
                break;
        }
    }
}