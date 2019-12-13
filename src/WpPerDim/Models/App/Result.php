<?php
namespace WpPerDim\Models\App;

use WpPerDim\Models\BaseModel;

/**
 * Result
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 * @see WpPerDim\Models\BaseModel
 */
class Result extends BaseModel{
    /**
    * @var $_table String
    */
    protected static $_table = 'wppd_results';
    
    /**
    * @var $_primaryKey String
    */
    protected static $_primaryKey = 'id';
    
    /**
    * Array of authorized database key name
    * @var $_fields Array
    */
    protected static $_fields = [
        'id',
        'title',
        'value',
        'period_id',
        'report_id',
    ];
    
    public function getReport(){
        return Report::find((int) $this->report_id);
    }
    
    public function getPeriod(){
        return Period::find((int) $this->period_id);
    }
    
    public function getIndicator(){
        return $this->getPeriod()?$this->getPeriod()->getIndicator():null;
    }
    
    public static function findOneByReportAndPeriod($report, $period){
        global $wpdb;
        $table_1 = $wpdb->prefix.'wppd_results';
        $sql = $wpdb->prepare(
            "SELECT t1.* FROM $table_1 t1 "
                . " WHERE t1.report_id = %d AND t1.period_id = %d",
            $report->id, 
            $period->id,
        );
        
        return $wpdb->get_row($sql);
    }
    
}