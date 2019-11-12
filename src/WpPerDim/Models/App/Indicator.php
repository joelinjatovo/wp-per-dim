<?php
namespace WpPerDim\Models\App;

use WpPerDim\Models\BaseModel;

/**
 * Indicator
 *
 * @author JOELINJATOVO
 * @version 1.0.0
 * @since 1.0.0
 * @see WpPerDim\Models\BaseModel
 */
class Indicator extends BaseModel{
    /**
    * @var $_table String
    */
    protected static $_table = 'wppd_indicators';
    
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
        'description',
        'graph',
        'unit_id',
    ];
    
    public function getPeriods(){
        global $wpdb;
        $table_name = $wpdb->prefix.Period::getTable();
        $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE `indicator_id` = %d;", [$this->getPkValue()]);
        $results = $wpdb->get_results($sql);
        if(is_array($results)){
            $output = [];
            foreach($results as $result){
                $output[] = Period::fromWp($result);
            }
            return $output;
        }else{
            return [];
        }
    }
    
}