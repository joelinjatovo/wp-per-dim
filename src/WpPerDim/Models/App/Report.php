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
        'type',
        'link',
        'indicator_id',
    ];
    
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
    
}