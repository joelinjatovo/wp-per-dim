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
        $id = 0;
        $model = null;
        if( isset($_GET['id']) ) {
            $id = (int) $_GET['id'];
            $model = Organism::find($id);
        }else if( isset($_POST['report-organism']) ){
            $id = (int) $_POST['report-organism'];
            $model = Organism::find($id);
        }
        if(!$model){ $model = new Organism(); }
        
        $models = Organism::getAll();
        $organisms = [];
        foreach($models as $organism){
            $organisms[] = Organism::fromWp($organism);
        }

        $template = WPPD_DIR . '/template/admin/report/create.php';
        
        if( file_exists( $template ) ) {
            include( $template );
        }
    }

    /**
     * Run POST request.
     * Override
     */
    public function save() {
        $id = 0;
        $model = null;
        if( isset($_GET['id']) ) {
            $id = (int) $_GET['id'];
        }

        if( isset($_POST['report-organism']) && is_numeric($_POST['report-organism']) ){
            $_organism = Organism::find((int) $_POST['report-organism'] );
            if( $_organism ){
                if(isset($_POST['reports']) && is_array($_POST['reports']) ){
                    $reports = $_POST['reports'];
                    foreach($reports as $report){
                        if( isset($report['indicator']) && is_numeric($report['indicator']) ) {
                            $_indicator = Indicator::find((int) $report['indicator']);
                            if($_indicator){
                                // Save or Update Report
                                $_report = Report::find((int) $report['id']);
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
    }
}