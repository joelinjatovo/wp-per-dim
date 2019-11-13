<?php
namespace WpPerDim\WordPress\Admin;

use WpPerDim\Models\App\Report;
use WpPerDim\Models\App\Indicator;
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
                $indicators = Indicator::getAll();
                
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
                
                if(isset($_POST['report-indicator'])){
                    $model->link = $_POST['report-link'];
                    $model->type = $_POST['report-type'];
                    $model->indicator_id = $_POST['report-indicator'];
                    $model->save();
                    
                    
                    if(isset($_POST['report-results']) && is_array($_POST['report-results']) ){
                        $news = [];
                        $results = $_POST['report-results'];
                        foreach($results as $key => $value){
                            if( is_array($value) && isset($value['id']) && isset($value['period']) && isset($value['value'])) {
                                $result = Result::find((int) $value['id']);
                                if( ! $result ) {
                                    $result = new Result();
                                    $result->period_id = $value['period'];
                                    $result->report_id = $model->getPkValue();
                                }
                                $result->value = $value['value'];
                                $result->save();
                                
                                $news[] = $result->getPkValue();
                            }
                        }
                        
                        global $wpdb;
                        $table_name = $wpdb->prefix.Result::getTable();
                        $ids = implode( ',', array_map( 'absint', $news ) );
                        $wpdb->query( "DELETE FROM $table_name WHERE `report_id` = {$model->getPkValue()} AND `id` NOT IN($ids)" );
                    }
                    Welcome::add_message(__('Votre modification a été bien enregistré.', 'nexway'));
                }
                
                break;
        }
    }
}