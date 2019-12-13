<?php
namespace WpPerDim\Models\App;

use WpPerDim\Models\BaseModel;

/**
 * Report
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 * @see WpPerDim\Models\BaseModel
 */
class Report extends BaseModel{
    /**
    * @var $_table String
    */
    protected static $_table = 'wppd_reports';
    
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
        'link',
        'indicator_id',
    ];
    
    /**
    * delete item
    */
    public function delete(){
        foreach($this->getResults() as $result){
            $result->delete(); 
        }
        parent::delete();
    }
    
    public function getIndicator(){
        return Indicator::find((int) $this->indicator_id);
    }
    
    public function getResults(){
        global $wpdb;
        $table_name = $wpdb->prefix.Result::getTable();
        $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE `report_id` = %d;", [$this->getPkValue()]);
        $results = $wpdb->get_results($sql);
        if(is_array($results)){
            $output = [];
            foreach($results as $result){
                $output[] = Result::fromWp($result);
            }
            return $output;
        }else{
            return [];
        }
    }
    
    public function getResultsPerPeriod(){
        $output = [];
        $results = $this->getResults();
        foreach($results as $result){
            $period = $result->getPeriod();
            if($period){
                if( ! isset( $output[$period->getPkValue()] ) ) {
                    $output[$period->getPkValue()] = [];
                }
                $output[$period->getPkValue()][] = $result;
            }
        }
        return $output;
    }
    
    public static function findOneByOrganismAndIndicator($organism, $indicator){
        global $wpdb;
        $table_1 = $wpdb->prefix.'wppd_reports';
        $table_2 = $wpdb->prefix.'wppd_indicators';
        $sql = $wpdb->prepare(
            "SELECT t1.* FROM $table_1 t1 "
                . " LEFT JOIN $table_2 t2 ON t1.indicator_id = t2.id "
                . " WHERE t2.organism_id = %d AND t1.indicator_id = %d",
            $organism->id, 
            $indicator->id,
        );
        
        return $wpdb->get_row($sql);
    }
    
}