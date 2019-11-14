<?php
namespace WpPerDim\Models\App;

use WpPerDim\Models\BaseModel;

/**
 * Tracker
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 * @see WpPerDim\Models\BaseModel
 */
class Tracker extends BaseModel{
    /**
    * @var $_table String
    */
    protected static $_table = 'wppd_trackers';
    
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
    ];
    
    public function getResults(?Indicator $indicator = null){
        global $wpdb;
        $t1 = $wpdb->prefix.Result::getTable();
        $t2 = $wpdb->prefix.Report::getTable();
        if($indicator){
            $sql = $wpdb->prepare("SELECT t1.* FROM $t1 AS t1 " .
                                  "JOIN $t2 ON t1.`report_id` = t2.`id` " .
                                  "WHERE t1.`tracker_id` = %d AND t2.`indicator_id` = %d;", [$this->getPkValue(), $indicator->getPkValue()]);
        }else{
            $sql = $wpdb->prepare("SELECT t1.* FROM $t1 AS t1 WHERE  t1.`tracker_id` = %d;", [$this->getPkValue()]);
        }
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